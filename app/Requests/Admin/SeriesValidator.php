<?php
namespace App\Requests\Admin;

use App\Models\Actor;
use App\Models\Category;
use App\Models\Tag;
use App\Requests\BaseRequestForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeriesValidator extends BaseRequestForm
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * Constructeur du validateur
     * 
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function rules(): array
    {
        return [
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
        ];
    }

    public function authorized()
    {
        return true;
    }
    
    /**
     * Récupère les données validées et formatées pour la création d'une série
     * avec toutes ses relations (catégories, tags, acteurs, épisodes)
     * 
     * @return array
     */
    public function getSeriesData()
    {
        // Données de base
        $data = [
            'title' => $this->request->title,
            'release_year' => $this->request->release_year,
            'description' => $this->request->description,
            'status' => 'ongoing', // valeur par défaut
            'maturity_rating' => 'PG',
        ];

        // Traitement de l'image de couverture
        if ($this->request->hasFile('cover_image')) {
            $coverPath = $this->request->file('cover_image')->store('covers', 'public');
            $data['cover_image'] = $coverPath;
        }

        // Traitement des catégories
        if ($this->request->has('category')) {
            $data['categories'] = $this->processCategoryData($this->request->category);
        }

        // Traitement des tags
        if ($this->request->has('tags')) {
            $data['tags'] = $this->processTagsData($this->request->tags);
        }

        // Traitement des acteurs
        if ($this->request->has('actors')) {
            $data['actors'] = $this->processActorsData($this->request->actors);
        }

        // Traitement des épisodes
        if ($this->request->has('episodes')) {
            $data['episodes'] = $this->processEpisodesData($this->request->episodes);
        }

        return $data;
    }

    /**
     * Traite les données de catégorie
     */
    private function processCategoryData($categoryName)
    {
        $category = Category::where('name', $categoryName)
            ->orWhere('slug', $categoryName)
            ->first();
        
        return $category ? [$category->id] : [];
    }

    /**
     * Traite les données des tags
     */
    private function processTagsData($tags)
    {
        $tagIds = [];
        $tags = Tag::whereIn('name', $tags)->get();
        foreach ($tags as $tag) {
            $tagIds[] = $tag->id;
        }
        return $tagIds;
    }

    /**
     * Traite les données des acteurs
     */
    private function processActorsData($actors)
    {
        $actorIds = [];
        foreach ($actors as $actorName) {
            // Essayer de trouver l'acteur par son nom ou créer un nouvel acteur
            $actor = Actor::firstOrCreate(['name' => $actorName]);
            $actorIds[] = $actor->id;
        }
        return $actorIds;
    }

    /**
     * Traite les données des épisodes
     */
    private function processEpisodesData($episodesData)
    {
        $episodes = [];
        
        foreach ($episodesData as $index => $episodeData) {
            $episode = [
                'title' => $episodeData['title'],
                'episode_number' => $episodeData['number'],
                'season_number' => 1, // valeur par défaut pour la saison
                'release_date' => now(),
                'views_count' => 0,
            ];
            
            // Ajouter l'ID de la série si spécifié
            if (isset($episodeData['series_id']) && !empty($episodeData['series_id'])) {
                $episode['series_id'] = $episodeData['series_id'];
            }
            
            // Ajouter l'ID de l'épisode s'il s'agit d'une mise à jour
            if (isset($episodeData['id']) && !empty($episodeData['id'])) {
                $episode['id'] = $episodeData['id'];
            }

            // Traitement du fichier vidéo
            if (isset($episodeData['video']) && $episodeData['video']) {
                $videoPath = $this->request->file("episodes.{$index}.video")->store('episodes', 'public');
                $episode['file_path'] = $videoPath;
            }

            $episodes[] = $episode;
        }
        
        return $episodes;
    }
} 