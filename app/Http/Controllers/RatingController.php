<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Content;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class RatingController extends BaseController
{
    /**
     * Ajouter ou mettre à jour une évaluation
     */
    public function rate(Request $request)
    {
        Log::info('Rating episode', $request->all());
        
        // Vérifier si l'utilisateur peut évaluer (premium uniquement)
        if (Gate::denies('rate-episode')) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seuls les utilisateurs premium peuvent évaluer des épisodes'
                ], 403);
            }
            
            return redirect()->back()
                             ->with('error', 'Seuls les utilisateurs premium peuvent évaluer des épisodes');
        }
        
        $request->validate([
            'content_id' => 'required|exists:contents,id',
            'value' => 'required|integer|min:1|max:10'
        ]);
        
        try {
            // Vérifier si l'utilisateur a déjà évalué ce contenu
            $existingRating = Rating::where('user_id', Auth::id())
                                  ->where('content_id', $request->content_id)
                                  ->first();
            
            if ($existingRating) {
                // Mettre à jour l'évaluation existante
                $existingRating->update([
                    'value' => $request->value
                ]);
                
                $message = 'Évaluation mise à jour avec succès';
                $rating = $existingRating;
            } else {
                // Créer une nouvelle évaluation
                $rating = Rating::create([
                    'user_id' => Auth::id(),
                    'content_id' => $request->content_id,
                    'value' => $request->value
                ]);
                
                $message = 'Évaluation ajoutée avec succès';
            }
            
            // Récupérer la note moyenne mise à jour
            $content = Content::find($request->content_id);
            $averageRating = $content->getAverageRatingAttribute();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'rating' => $rating,
                    'average_rating' => round($averageRating, 1)
                ]);
            }
            
            return redirect()->back()->with('success', $message);
            
        } catch (\Exception $e) {
            Log::error('Error rating content', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Une erreur est survenue lors de l\'évaluation'
                ], 500);
            }
            
            return redirect()->back()
                             ->with('error', 'Une erreur est survenue lors de l\'évaluation');
        }
    }
    
    /**
     * Supprimer une évaluation
     */
    public function destroy(Request $request, $contentId)
    {
        // Vérifier si l'utilisateur a une évaluation pour ce contenu
        $rating = Rating::where('user_id', Auth::id())
                      ->where('content_id', $contentId)
                      ->first();
        
        if (!$rating) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n\'avez pas évalué ce contenu'
                ], 404);
            }
            
            return redirect()->back()
                             ->with('error', 'Vous n\'avez pas évalué ce contenu');
        }
        
        try {
            $rating->delete();
            
            // Récupérer la note moyenne mise à jour
            $content = Content::find($contentId);
            $averageRating = $content->getAverageRatingAttribute() ?? 0;
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Évaluation supprimée avec succès',
                    'average_rating' => round($averageRating, 1)
                ]);
            }
            
            return redirect()->back()
                             ->with('success', 'Évaluation supprimée avec succès');
            
        } catch (\Exception $e) {
            Log::error('Error deleting rating', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'content_id' => $contentId
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Une erreur est survenue lors de la suppression de l\'évaluation'
                ], 500);
            }
            
            return redirect()->back()
                             ->with('error', 'Une erreur est survenue lors de la suppression de l\'évaluation');
        }
    }
    
    /**
     * Obtenir la note de l'utilisateur pour un contenu
     */
    public function getUserRating(Request $request, $contentId)
    {
        $rating = Rating::where('user_id', Auth::id())
                      ->where('content_id', $contentId)
                      ->first();
        
        return response()->json([
            'success' => true,
            'rating' => $rating ? $rating->value : null
        ]);
    }
    
    /**
     * Obtenir la note moyenne pour un contenu
     */
    public function getAverageRating(Request $request, $contentId)
    {
        $content = Content::find($contentId);
        
        if (!$content) {
            return response()->json([
                'success' => false,
                'message' => 'Contenu non trouvé'
            ], 404);
        }
        
        $averageRating = $content->getAverageRatingAttribute() ?? 0;
        
        return response()->json([
            'success' => true,
            'average_rating' => round($averageRating, 1),
            'ratings_count' => $content->ratings()->count()
        ]);
    }
} 