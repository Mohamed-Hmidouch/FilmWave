<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Episode;
use App\Models\Content;
use App\Models\Series;
use App\Services\CommentService;
use App\Requests\Comment\CommentValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CommentController extends BaseController
{
    protected $commentService;

    /**
     * Injection du service de commentaires
     */
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Afficher tous les commentaires d'un contenu
     */
    public function index(Request $request, $contentId)
    {
        // Vérifier si l'utilisateur peut voir les commentaires
        if (Auth::check() && Gate::denies('view-comments')) {
            return redirect()->back()->with('error', 'Cette fonctionnalité est réservée aux utilisateurs premium');
        }
        
        $comments = $this->commentService->getContentComments($contentId);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'comments' => $comments
            ]);
        }
        
        return view('comments.index', compact('comments', 'contentId'));
    }

    /**
     * Enregistrer un nouveau commentaire
     */
    public function store(Request $request, CommentValidator $validator)
    {
        Log::info('Comment store method called', $request->all());
        
        // Vérifier si l'utilisateur peut ajouter des commentaires
        if (Gate::denies('add-comment')) {
            return redirect()->back()->with('error', 'Seuls les utilisateurs premium peuvent ajouter des commentaires');
        }
        
        // Utiliser directement le validateur personnalisé
        if (!$validator->isStatus()) {
            Log::error('Comment validation failed', ['errors' => $validator->getErrors()]);
            return redirect()->back()->withErrors($validator->getErrors())->withInput();
        }
        
        // Récupérer les données validées directement de la requête
        $validated = $request->only(['episode_id', 'series_id', 'body']);
        
        try {
            // Commencer une transaction pour s'assurer que toutes les opérations sont atomiques
            return DB::transaction(function() use ($validated) {
                // Récupérer l'épisode
                $episode = Episode::findOrFail($validated['episode_id']);
                $series = Series::findOrFail($validated['series_id']);
                
                // Récupérer ou créer le content_id
                $contentId = $this->getOrCreateContentId($episode, $series);
                
                if (!$contentId) {
                    Log::error('Cannot determine content_id for comment', [
                        'episode_id' => $validated['episode_id'],
                        'series_id' => $validated['series_id']
                    ]);
                    
                    return redirect()->back()->with('error', 'Impossible d\'ajouter un commentaire à cet épisode');
                }
                
                // Créer le commentaire
                $comment = $this->commentService->create([
                    'content_id' => $contentId,
                    'user_id' => Auth::id(),
                    'body' => $validated['body']
                ]);
                
                Log::info('Comment created successfully', [
                    'comment_id' => $comment->id,
                    'content_id' => $contentId,
                    'episode_id' => $validated['episode_id']
                ]);
                
                return redirect()->back()->with('success', 'Commentaire ajouté avec succès');
            });
        } catch (\Exception $e) {
            Log::error('Error creating comment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'ajout du commentaire');
        }
    }

    /**
     * Récupère ou crée un content_id pour un épisode
     *
     * @param Episode $episode
     * @param Series $series
     * @return int|null
     */
    private function getOrCreateContentId(Episode $episode, Series $series)
    {
        // Si l'épisode a déjà un content_id
        if ($episode->content_id) {
            return $episode->content_id;
        }
        
        // Si l'épisode a une relation content chargée
        if ($episode->relationLoaded('content') && $episode->content) {
            return $episode->content->id;
        }
        
        // Essayer de charger la relation si elle n'est pas déjà chargée
        if (!$episode->relationLoaded('content')) {
            $episode->load('content');
            if ($episode->content) {
                return $episode->content->id;
            }
        }
        
        // Créer un nouveau content pour cet épisode
        $content = Content::create([
            'title' => $episode->title ?? ('Épisode ' . $episode->episode_number),
            'description' => $episode->description ?? ('Épisode ' . $episode->episode_number . ' de la saison ' . $episode->season_number),
            'type' => 'episode',
            'release_year' => date('Y'),
            'duration' => $episode->duration ?? 0,
        ]);
        
        // Mettre à jour l'épisode avec le nouveau content_id
        $episode->content_id = $content->id;
        $episode->save();
        
        Log::info('Created new content for episode', [
            'episode_id' => $episode->id,
            'content_id' => $content->id
        ]);
        
        return $content->id;
    }

    /**
     * Supprimer un commentaire
     */
    public function destroy(Request $request, $id)
    {
        Log::info('Comment delete method called', ['comment_id' => $id, 'user_id' => Auth::id()]);
        
        // Vérifier si l'utilisateur peut ajouter des commentaires
        if (Gate::denies('add-comment')) {
            return redirect()->back()->with('error', 'Seuls les utilisateurs premium peuvent gérer des commentaires');
        }
        
        try {
            $deleted = $this->commentService->delete($id, Auth::id());

            if (!$deleted) {
                Log::warning('Unauthorized comment deletion attempt', [
                    'comment_id' => $id, 
                    'user_id' => Auth::id()
                ]);
                
                return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à supprimer ce commentaire');
            }
            
            Log::info('Comment deleted successfully', ['comment_id' => $id]);
            
            return redirect()->back()->with('success', 'Commentaire supprimé avec succès');
        } catch (\Exception $e) {
            Log::error('Error deleting comment', [
                'comment_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression du commentaire');
        }
    }

    /**
     * Mettre à jour un commentaire
     */
    public function update(Request $request, CommentValidator $validator, $id)
    {
        Log::info('Comment update method called', ['comment_id' => $id, 'user_id' => Auth::id()]);
        
        // Vérifier si l'utilisateur peut ajouter des commentaires
        if (Gate::denies('add-comment')) {
            return redirect()->back()->with('error', 'Seuls les utilisateurs premium peuvent gérer des commentaires');
        }
        
        // Utiliser directement le validateur personnalisé
        if (!$validator->isStatus()) {
            Log::error('Comment validation failed', ['errors' => $validator->getErrors()]);
            return redirect()->back()->withErrors($validator->getErrors())->withInput();
        }

        try {
            $comment = $this->commentService->update($id, $request->input('body'), Auth::id());

            if (!$comment) {
                Log::warning('Unauthorized comment update attempt', [
                    'comment_id' => $id, 
                    'user_id' => Auth::id()
                ]);
                
                return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier ce commentaire');
            }
            
            Log::info('Comment updated successfully', ['comment_id' => $id]);
            
            return redirect()->back()->with('success', 'Commentaire mis à jour avec succès');
        } catch (\Exception $e) {
            Log::error('Error updating comment', [
                'comment_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour du commentaire');
        }
    }
}