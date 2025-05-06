<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Content;
use App\Models\Episode;
use App\Repositories\PlaylistRepository;
use App\Requests\User\PlaylistValidator;
use App\Requests\User\PlaylistContentValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class PlaylistController extends BaseController
{
    /**
     * Le repository pour la gestion des playlists
     * 
     * @var PlaylistRepository
     */
    protected $playlistRepository;

    /**
     * Constructeur du contrôleur
     * 
     * @param PlaylistRepository $playlistRepository
     */
    public function __construct(PlaylistRepository $playlistRepository)
    {
        parent::__construct();
        $this->playlistRepository = $playlistRepository;
    }

    /**
     * Afficher toutes les playlists de l'utilisateur
     */
    public function index(Request $request)
    {
        $playlists = $this->playlistRepository->getUserPlaylists(Auth::id());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'playlists' => $playlists
            ]);
        }
        
        return $this->view('playlists.index', compact('playlists'));
    }
    
    /**
     * Afficher le formulaire de création d'une playlist
     */
    public function create()
    {
        return $this->view('playlists.create');
    }
    
    /**
     * Enregistrer une nouvelle playlist
     */
    public function store(Request $request)
    {
        $validator = new PlaylistValidator($request);
        
        $playlist = $this->playlistRepository->create($request->all(), Auth::id());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'playlist' => $playlist,
                'message' => 'Playlist créée avec succès'
            ]);
        }
        
        return redirect()->route('playlists.show', $playlist->id)
                         ->with('success', 'Playlist créée avec succès');
    }
    
    /**
     * Afficher une playlist spécifique
     */
    public function show(Playlist $playlist)
    {
        // Vérifier si l'utilisateur peut voir cette playlist
        if (!$this->playlistRepository->canView($playlist, Auth::id())) {
            return redirect()->route('playlists.index')
                             ->with('error', 'Vous n\'êtes pas autorisé à voir cette playlist');
        }
        
        $this->playlistRepository->loadContents($playlist);
        
        return $this->view('playlists.show', compact('playlist'));
    }
    
    /**
     * Afficher le formulaire d'édition d'une playlist
     */
    public function edit(Playlist $playlist)
    {
        // Vérifier si l'utilisateur est le propriétaire
        if (!$this->playlistRepository->isOwner($playlist, Auth::id())) {
            return redirect()->route('playlists.index')
                             ->with('error', 'Vous n\'êtes pas autorisé à modifier cette playlist');
        }
        
        return $this->view('playlists.edit', compact('playlist'));
    }
    
    /**
     * Mettre à jour une playlist
     */
    public function update(Request $request, Playlist $playlist)
    {
        // Vérifier si l'utilisateur est le propriétaire
        if (!$this->playlistRepository->isOwner($playlist, Auth::id())) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n\'êtes pas autorisé à modifier cette playlist'
                ], 403);
            }
            
            return redirect()->route('playlists.index')
                             ->with('error', 'Vous n\'êtes pas autorisé à modifier cette playlist');
        }
        
        $validator = new PlaylistValidator($request);
        
        $this->playlistRepository->update($playlist, $request->all());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'playlist' => $playlist,
                'message' => 'Playlist mise à jour avec succès'
            ]);
        }
        
        return redirect()->route('playlists.show', $playlist->id)
                         ->with('success', 'Playlist mise à jour avec succès');
    }
    
    /**
     * Supprimer une playlist
     */
    public function destroy(Request $request, Playlist $playlist)
    {
        // Vérifier si l'utilisateur est le propriétaire
        if (!$this->playlistRepository->isOwner($playlist, Auth::id())) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n\'êtes pas autorisé à supprimer cette playlist'
                ], 403);
            }
            
            return redirect()->route('playlists.index')
                             ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette playlist');
        }
        
        $this->playlistRepository->delete($playlist);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Playlist supprimée avec succès'
            ]);
        }
        
        return redirect()->route('playlists.index')
                         ->with('success', 'Playlist supprimée avec succès');
    }
    
    /**
     * Ajouter un contenu à une playlist
     */
    public function addToPlaylist(Request $request)
    {
        // Vérifier si l'utilisateur peut ajouter à une playlist (premium uniquement)
        if (Gate::denies('add-to-playlist')) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seuls les utilisateurs premium peuvent ajouter des contenus à leurs playlists'
                ], 403);
            }
            
            return redirect()->back()
                             ->with('error', 'Seuls les utilisateurs premium peuvent ajouter des contenus à leurs playlists');
        }
        
        $validator = new PlaylistContentValidator($request);
        
        $playlist = $this->playlistRepository->findById($request->playlist_id);
        
        // Vérifier si le contenu existe déjà dans la playlist
        if ($this->playlistRepository->hasContent($playlist, $request->content_id)) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce contenu est déjà dans votre playlist'
                ]);
            }
            
            return redirect()->back()
                             ->with('info', 'Ce contenu est déjà dans votre playlist');
        }
        
        // Ajouter le contenu à la playlist
        $this->playlistRepository->addContent($playlist, $request->content_id);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Contenu ajouté à votre playlist avec succès'
            ]);
        }
        
        return redirect()->back()
                         ->with('success', 'Contenu ajouté à votre playlist avec succès');
    }
    
    /**
     * Retirer un contenu d'une playlist
     */
    public function removeFromPlaylist(Request $request)
    {
        $validator = new PlaylistContentValidator($request);
        
        $playlist = $this->playlistRepository->findById($request->playlist_id);
        
        // Retirer le contenu de la playlist
        $this->playlistRepository->removeContent($playlist, $request->content_id);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Contenu retiré de votre playlist avec succès'
            ]);
        }
        
        return redirect()->back()
                         ->with('success', 'Contenu retiré de votre playlist avec succès');
    }
    
    /**
     * Ajouter rapidement un contenu à la liste "Ma Liste"
     */
    public function toggleMyList(Request $request)
    {
        // Vérifier si l'utilisateur peut ajouter à une playlist (premium uniquement)
        if (Gate::denies('add-to-playlist')) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seuls les utilisateurs premium peuvent utiliser Ma Liste',
                    'action' => 'error'
                ], 403);
            }
            
            return redirect()->back()
                             ->with('error', 'Seuls les utilisateurs premium peuvent utiliser Ma Liste');
        }
        
        $request->validate([
            'content_id' => 'required|exists:contents,id'
        ]);
        
        $result = $this->playlistRepository->toggleInMyList(Auth::id(), $request->content_id);
        
        if ($request->ajax()) {
            return response()->json($result);
        }
        
        return redirect()->back()->with('success', $result['message']);
    }
    
    /**
     * Afficher la liste "Ma Liste" de l'utilisateur
     */
    public function myList()
    {
        $myList = $this->playlistRepository->getMyListWithContents(Auth::id());
        
        return $this->view('playlists.my-list', ['playlist' => $myList]);
    }
}