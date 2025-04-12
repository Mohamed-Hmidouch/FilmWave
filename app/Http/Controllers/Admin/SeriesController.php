<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\SeriesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Actor;

class SeriesController extends BaseController
{
    /**
     * Display a listing of the resource.
     */

    public $SeriesService;
     public function __construct(SeriesService $SeriesService){
          $this->SeriesService = $SeriesService;
     }
    public function index()
    {
        return view('admin.Series');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validation des données
            $request->validate([
                'title' => 'required|string|max:255',
                'release_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
                'description' => 'nullable|string',
                'cover_image' => 'nullable|image|max:51200', // 50MB max
                'tags' => 'nullable|array',
                'actors' => 'nullable|array',
                'category' => 'nullable|string',
                'episodes' => 'nullable|array',
                'episodes.*.title' => 'required|string|max:255',
                'episodes.*.number' => 'required|integer|min:1',
                'episodes.*.video' => 'nullable|file|mimes:mp4|max:102400', // 100MB max
            ]);

            // Préparer les données pour la création
            $data = [
                'title' => $request->title,
                'release_year' => $request->release_year,
                'description' => $request->description,
                'status' => 'ongoing', // valeur par défaut
                'maturity_rating' => 'PG',
            ];

            // Traitement de l'image de couverture
            if ($request->hasFile('cover_image')) {
                $coverPath = $request->file('cover_image')->store('covers', 'public');
                $data['cover_image'] = $coverPath;
            }

            // Traitement des catégories
            if ($request->has('category')) {
                // Récupérer l'ID de la catégorie à partir de son nom
                $category = Category::where('name', $request->category)
                    ->orWhere('slug', $request->category)
                    ->first();
                
                if ($category) {
                    $data['categories'] = [$category->id];
                }
            }

            // Traitement des tags
            if ($request->has('tags')) {
                // Récupérer les IDs des tags à partir de leurs noms
                $tagIds = [];
                $tags = Tag::whereIn('name', $request->tags)->get();
                foreach ($tags as $tag) {
                    $tagIds[] = $tag->id;
                }
                $data['tags'] = $tagIds;
            }

            // Traitement des acteurs
            if ($request->has('actors')) {
                $actorIds = [];
                foreach ($request->actors as $actorName) {
                    // Essayer de trouver l'acteur par son nom ou créer un nouvel acteur
                    $actor = Actor::firstOrCreate(['name' => $actorName]);
                    $actorIds[] = $actor->id;
                }
                $data['actors'] = $actorIds;
            }

            // Traitement des épisodes
            if ($request->has('episodes')) {
                $episodes = [];
                foreach ($request->episodes as $index => $episodeData) {
                    $episode = [
                        'title' => $episodeData['title'],
                        'episode_number' => $episodeData['number'],
                        'season_number' => 1, // valeur par défaut pour la saison
                    ];

                    // Traitement du fichier vidéo
                    if (isset($episodeData['video']) && $episodeData['video']) {
                        $videoPath = $request->file("episodes.{$index}.video")->store('episodes', 'public');
                        $episode['file_path'] = $videoPath;
                    }

                    $episodes[] = $episode;
                }
                $data['episodes'] = $episodes;
            }

            // Créer la série
            $this->SeriesService->createSeries($data);

            return redirect()->route('admin.series.index')
                ->with('success', 'Série créée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de la série: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
