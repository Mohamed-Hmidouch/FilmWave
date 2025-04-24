<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Content;
use App\Repositories\Interfaces\SeriesRepositoryInterface;
use App\Services\CommentService;
use Illuminate\Support\Facades\Log;

class VideoPlayerController extends BaseController
{
    /**
     * @var SeriesRepositoryInterface
     */
    protected $seriesRepository;

    /**
     * @var CommentService
     */
    protected $commentService;

    /**
     * VideoPlayerController constructor.
     *
     * @param SeriesRepositoryInterface $seriesRepository
     * @param CommentService $commentService
     */
    public function __construct(SeriesRepositoryInterface $seriesRepository, CommentService $commentService)
    {
        $this->seriesRepository = $seriesRepository;
        $this->commentService = $commentService;
    }

    /**
     * Afficher la page de visionnage d'un épisode
     *
     * @param  int  $seriesId
     * @param  int|null  $episodeId
     * @return \Illuminate\View\View
     */
    public function watchEpisode($seriesId, $episodeId = null)
    {
        try {
            // Convertir les paramètres en entiers pour s'assurer qu'ils sont traités comme des nombres
            $seriesId = (int)$seriesId;
            $episodeId = $episodeId ? (int)$episodeId : null;
            
            // Récupérer la série avec ses relations
            $series = $this->seriesRepository->findById($seriesId, ['content', 'seasons.episodes']);
            
            if (!$series) {
                abort(404, 'Série non trouvée');
            }
            
            // Déterminer l'épisode à afficher
            $episode = $this->getEpisodeToDisplay($series, $episodeId);
            
            // Vérifier si l'épisode appartient bien à cette série
            if ($episode->series_id != $seriesId) {
                // Rediriger vers la bonne série si épisode trouvé mais dans la mauvaise série
                return redirect()->route('watch.episode', [
                    'seriesId' => $episode->series_id,
                    'episodeId' => $episode->id
                ]);
            }
            
            // Récupérer la saison actuelle
            $currentSeason = $this->getCurrentSeason($series, $episode);
            
            // Préparation des données pour la vue
            $episodeData = $this->prepareEpisodeData($episode, $currentSeason);
            $seriesData = $this->prepareSeriesData($series, $currentSeason);
            
            // Incrémenter le nombre de vues
            $this->incrementViewCount($episode);
            
            // Récupérer les informations sur le prochain épisode
            $nextEpisode = $this->getNextEpisode($seriesId, $episode);
            
            // Récupérer la liste des saisons pour le sélecteur
            $seasons = Season::where('series_id', $seriesId)
                ->orderBy('season_number')
                ->pluck('season_number')
                ->unique()
                ->values()
                ->all();
                
            // Récupérer les épisodes de la saison courante
            $seasonEpisodes = $this->getSeasonEpisodes($seriesId, $currentSeason);
            
            // Récupérer les commentaires pour cet épisode
            $comments = collect([]);
            if ($episode->content_id) {
                $comments = $this->commentService->getContentComments($episode->content_id);
            }
            
            return view('watch.episode', [
                'episode' => $episodeData,
                'series' => $seriesData,
                'nextEpisode' => $nextEpisode,
                'seasons' => $seasons,
                'seasonEpisodes' => $seasonEpisodes,
                'currentSeason' => $currentSeason,
                'comments' => $comments
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors du chargement de l\'épisode: ' . $e->getMessage(), [
                'seriesId' => $seriesId,
                'episodeId' => $episodeId,
                'exception' => $e
            ]);
            abort(500, 'Une erreur est survenue lors du chargement de l\'épisode');
        }
    }

    /**
     * Récupère l'épisode à afficher
     * 
     * @param \App\Models\Series $series
     * @param int|null $episodeId
     * @return \App\Models\Episode
     */
    private function getEpisodeToDisplay($series, $episodeId = null)
    {
        if ($episodeId) {
            try {
                // Récupérer l'épisode spécifié
                $episode = Episode::with('content')->findOrFail($episodeId);
                
                // Vérifier si l'épisode appartient à la série spécifiée
                // Cette vérification n'échoue pas intentionnellement pour permettre la redirection
                return $episode;
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                // Si l'épisode n'existe pas, utiliser le premier épisode de la série
                Log::warning('Épisode non trouvé, utilisation du premier épisode de la série', [
                    'series_id' => $series->id,
                    'requested_episode_id' => $episodeId
                ]);
                
                // On continue vers le code ci-dessous pour trouver le premier épisode
            }
        }
        
        // Si aucun épisode spécifié ou épisode non trouvé, utiliser le premier épisode
        $firstSeason = $series->seasons()->first();
        if (!$firstSeason) {
            abort(404, 'Aucune saison disponible pour cette série');
        }
        
        $episode = Episode::where('series_id', $series->id)
                        ->where('season_number', $firstSeason->season_number)
                        ->orderBy('episode_number')
                        ->first();
                        
        if (!$episode) {
            abort(404, 'Aucun épisode disponible pour cette série');
        }
        
        return $episode;
    }

    /**
     * Récupère la saison actuelle
     * 
     * @param \App\Models\Series $series
     * @param \App\Models\Episode $episode
     * @return \App\Models\Season
     */
    private function getCurrentSeason($series, $episode)
    {
        // Si $series->seasons est une collection, on peut utiliser first()
        if ($series->seasons instanceof \Illuminate\Database\Eloquent\Collection) {
            $currentSeason = $series->seasons->first(function ($season) use ($episode) {
                return $season->episodes->contains('id', $episode->id);
            });
            
            if ($currentSeason) {
                return $currentSeason;
            }
        }
        
        // Sinon, récupérer la saison directement par le numéro de saison de l'épisode
        $currentSeason = Season::where('series_id', $series->id)
                            ->where('season_number', $episode->season_number)
                            ->first();
                            
        if (!$currentSeason) {
            abort(404, 'Saison non trouvée');
        }
        
        return $currentSeason;
    }

    /**
     * Prépare les données de l'épisode pour la vue
     * 
     * @param \App\Models\Episode $episode
     * @param \App\Models\Season $currentSeason
     * @return \stdClass
     */
    private function prepareEpisodeData($episode, $currentSeason)
    {
        $contentFiles = $episode->content->contentFiles ?? collect([]);
        $firstFile = $contentFiles->first();
        $filePath = $firstFile ? $firstFile->file_path : null;
        
        // Si le filePath est null, utiliser le file_path directement de l'épisode
        if (!$filePath && !empty($episode->file_path)) {
            $filePath = $episode->file_path;
        }
        
        // Construction de l'URL de la vidéo
        $videoUrl = $filePath ? asset('storage/' . $filePath) : null;
        
        return (object)[
            'id' => $episode->id,
            'title' => $episode->title,
            'thumbnail' => $episode->content->cover_image ?? null,
            'description' => $episode->content->description ?? null,
            'video_url' => $videoUrl,
            'file_path' => $episode->file_path,
            'season_number' => $currentSeason->season_number,
            'episode_number' => $episode->episode_number,
            'duration' => $episode->content->duration ?? null,
            'release_date' => $episode->release_date ?? null
        ];
    }

    /**
     * Prépare les données de la série pour la vue
     * 
     * @param \App\Models\Series $series
     * @param \App\Models\Season $currentSeason
     * @return \stdClass
     */
    private function prepareSeriesData($series, $currentSeason)
    {
        return (object)[
            'id' => $series->id,
            'title' => $series->title,
            'poster' => $series->content->cover_image ?? null,
            'release_year' => $series->content->release_year ?? null,
            'age_rating' => $series->content->maturity_rating ?? null,
            'episodes' => $series->episodes ?? collect([]),
            'seasons' => $series->seasons instanceof \Illuminate\Database\Eloquent\Collection 
                ? $series->seasons 
                : collect([]),
            'content' => $series->content,
            'status' => $series->status
        ];
    }

    /**
     * Récupère le prochain épisode
     * 
     * @param int $seriesId
     * @param \App\Models\Episode $episode
     * @return \stdClass|null
     */
    private function getNextEpisode($seriesId, $episode)
    {
        // Tenter de trouver le prochain épisode dans la même saison
        $nextEpisode = Episode::where('series_id', $seriesId)
            ->where('season_number', $episode->season_number)
            ->where('episode_number', '>', $episode->episode_number)
            ->orderBy('episode_number')
            ->first();
            
        // Si pas de prochain épisode dans cette saison, chercher le premier épisode de la saison suivante
        if (!$nextEpisode) {
            $nextSeason = Season::where('series_id', $seriesId)
                ->where('season_number', '>', $episode->season_number)
                ->orderBy('season_number')
                ->first();
                
            if ($nextSeason) {
                $nextEpisode = Episode::where('series_id', $seriesId)
                    ->where('season_number', $nextSeason->season_number)
                    ->orderBy('episode_number')
                    ->first();
            }
        }
        
        // Si trouvé, préparer les données du prochain épisode pour l'affichage
        if ($nextEpisode) {
            return (object)[
                'id' => $nextEpisode->id,
                'title' => $nextEpisode->title,
                'thumbnail' => $nextEpisode->content->cover_image ?? null,
                'episode_number' => $nextEpisode->episode_number,
                'season_number' => $nextEpisode->season_number
            ];
        }
        
        return null;
    }

    /**
     * Récupère les épisodes de la saison courante
     * 
     * @param int $seriesId
     * @param \App\Models\Season $currentSeason
     * @return \Illuminate\Support\Collection
     */
    private function getSeasonEpisodes($seriesId, $currentSeason)
    {
        return Episode::where('series_id', $seriesId)
            ->where('season_number', $currentSeason->season_number)
            ->orderBy('episode_number')
            ->get()
            ->map(function ($ep) {
                return (object)[
                    'id' => $ep->id,
                    'title' => $ep->title,
                    'thumbnail' => $ep->content->cover_image ?? null,
                    'episode_number' => $ep->episode_number,
                    'duration' => $ep->content->duration ?? null
                ];
            });
    }

    /**
     * Incrémente le nombre de vues pour un épisode
     * 
     * @param \App\Models\Episode $episode
     * @return void
     */
    private function incrementViewCount($episode)
    {
        if ($episode->content) {
            // Récupérer l'objet Content directement pour éviter les problèmes de "indirect modification"
            $content = Content::find($episode->content->id);
            if ($content) {
                $content->views_count = ($content->views_count ?? 0) + 1;
                $content->save();
            }
        }
        
        // Log de visionnage
        Log::info("Épisode {$episode->id} visionné", [
            'user_id' => auth()->id() ?? 'guest',
            'series_id' => $episode->series_id,
            'episode_id' => $episode->id
        ]);
    }

    /**
     * Afficher la page de présentation d'une série (accessible sans authentification)
     * Si l'utilisateur tente de regarder un épisode, il sera redirigé vers la page de connexion
     *
     * @param  int  $seriesId
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showSeries($seriesId)
    {
        try {
            // Convertir l'ID en entier
            $seriesId = (int)$seriesId;
            
            // Récupérer la série avec ses relations
            $series = $this->seriesRepository->findById($seriesId, ['content', 'seasons.episodes']);
            
            if (!$series) {
                abort(404, 'Série non trouvée');
            }
            
            // Récupérer la première saison
            $firstSeason = $series->seasons()->first();
            if (!$firstSeason) {
                abort(404, 'Aucune saison disponible pour cette série');
            }
            
            // Récupérer les épisodes de la première saison
            $episodes = Episode::where('series_id', $seriesId)
                ->where('season_number', $firstSeason->season_number)
                ->orderBy('episode_number')
                ->get()
                ->map(function ($ep) {
                    return (object)[
                        'id' => $ep->id,
                        'title' => $ep->title,
                        'thumbnail' => $ep->content->cover_image ?? null,
                        'episode_number' => $ep->episode_number,
                        'duration' => $ep->content->duration ?? null,
                        'description' => $ep->content->description ?? null
                    ];
                });
                
            // Récupérer la liste des saisons pour le sélecteur
            $seasons = Season::where('series_id', $seriesId)
                ->orderBy('season_number')
                ->pluck('season_number')
                ->unique()
                ->values()
                ->all();
                
            // Préparer les données de la série
            $seriesData = (object)[
                'id' => $series->id,
                'title' => $series->title,
                'poster' => $series->content->cover_image ?? null,
                'release_year' => $series->content->release_year ?? null,
                'age_rating' => $series->content->maturity_rating ?? null,
                'description' => $series->content->description ?? null,
                'seasons_count' => $series->seasons->count(),
                'total_episodes' => $series->episodes()->count(),
                'content' => $series->content,
                'status' => $series->status ?? 'ongoing'
            ];
            
            return view('series.show', [
                'series' => $seriesData,
                'episodes' => $episodes,
                'seasons' => $seasons,
                'currentSeason' => $firstSeason,
                'authRequired' => true // Indique que l'authentification est requise pour regarder un épisode
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors du chargement de la série: ' . $e->getMessage(), [
                'seriesId' => $seriesId,
                'exception' => $e
            ]);
            abort(500, 'Une erreur est survenue lors du chargement de la série');
        }
    }
}