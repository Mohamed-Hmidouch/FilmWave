<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Content;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class PlaylistController extends BaseController
{
    /**
     * Afficher toutes les playlists de l'utilisateur
     */
    public function index(Request $request)
    {
        $playlists = Auth::user()->playlists()->with('contents')->get();
        
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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'boolean'
        ]);
        
        $playlist = Auth::user()->playlists()->create([
            'name' => $request->name,
            'description' => $request->description,
            'is_public' => $request->is_public ?? false
        ]);
        
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
        if ($playlist->user_id !== Auth::id() && !$playlist->is_public) {
            return redirect()->route('playlists.index')
                             ->with('error', 'Vous n\'êtes pas autorisé à voir cette playlist');
        }
        
        $playlist->load('contents');
        
        return $this->view('playlists.show', compact('playlist'));
    }
    
    /**
     * Afficher le formulaire d'édition d'une playlist
     */
    public function edit(Playlist $playlist)
    {
        // Vérifier si l'utilisateur est le propriétaire
        if ($playlist->user_id !== Auth::id()) {
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
        if ($playlist->user_id !== Auth::id()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n\'êtes pas autorisé à modifier cette playlist'
                ], 403);
            }
            
            return redirect()->route('playlists.index')
                             ->with('error', 'Vous n\'êtes pas autorisé à modifier cette playlist');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'boolean'
        ]);
        
        $playlist->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_public' => $request->is_public ?? false
        ]);
        
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
        if ($playlist->user_id !== Auth::id()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n\'êtes pas autorisé à supprimer cette playlist'
                ], 403);
            }
            
            return redirect()->route('playlists.index')
                             ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette playlist');
        }
        
        $playlist->delete();
        
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
     * Ajouter un épisode à une playlist
     */
    public function addToPlaylist(Request $request)
    {
        // Vérifier si l'utilisateur peut ajouter à une playlist (premium uniquement)
        if (Gate::denies('add-to-playlist')) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seuls les utilisateurs premium peuvent ajouter des épisodes à leurs playlists'
                ], 403);
            }
            
            return redirect()->back()
                             ->with('error', 'Seuls les utilisateurs premium peuvent ajouter des épisodes à leurs playlists');
        }
        
        $request->validate([
            'playlist_id' => 'required|exists:playlists,id',
            'content_id' => 'required|exists:contents,id'
        ]);
        
        $playlist = Playlist::find($request->playlist_id);
        
        // Vérifier si l'utilisateur est le propriétaire de la playlist
        if ($playlist->user_id !== Auth::id()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n\'êtes pas autorisé à modifier cette playlist'
                ], 403);
            }
            
            return redirect()->back()
                             ->with('error', 'Vous n\'êtes pas autorisé à modifier cette playlist');
        }
        
        // Vérifier si le contenu existe déjà dans la playlist
        if ($playlist->contents()->where('content_id', $request->content_id)->exists()) {
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
        $playlist->addContent($request->content_id);
        
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
     * Retirer un épisode d'une playlist
     */
    public function removeFromPlaylist(Request $request)
    {
        $request->validate([
            'playlist_id' => 'required|exists:playlists,id',
            'content_id' => 'required|exists:contents,id'
        ]);
        
        $playlist = Playlist::find($request->playlist_id);
        
        // Vérifier si l'utilisateur est le propriétaire de la playlist
        if ($playlist->user_id !== Auth::id()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n\'êtes pas autorisé à modifier cette playlist'
                ], 403);
            }
            
            return redirect()->back()
                             ->with('error', 'Vous n\'êtes pas autorisé à modifier cette playlist');
        }
        
        // Retirer le contenu de la playlist
        $playlist->removeContent($request->content_id);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Contenu retiré de votre playlist avec succès'
            ]);
        }
        
        return redirect()->back()
                         ->with('success', 'Contenu retiré de votre playlist avec succès');
    }
} 