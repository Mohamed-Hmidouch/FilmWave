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

    protected $seriesRepository;


    protected $commentService;

    public function __construct(SeriesRepositoryInterface $seriesRepository, CommentService $commentService)
    {
        $this->seriesRepository = $seriesRepository;
        $this->commentService = $commentService;
    }

    public function watchEpisode($seriesId, $episodeId = null)
    {
        try {
            $seriesId = (int)$seriesId;
            $episodeId = $episodeId ? (int)$episodeId : null;
            
            $series = $this->seriesRepository->findById($seriesId, ['content', 'seasons.episodes']);
            
            if (!$series) {
                abort(404, 'Série non trouvée');
            }
            
            $episode = $this->getEpisodeToDisplay($series, $episodeId);
            
            if ($episode->series_id != $seriesId) {
                return redirect()->route('watch.episode', [
                    'seriesId' => $episode->series_id,
                    'episodeId' => $episode->id
                ]);
            }
            
            $currentSeason = $this->getCurrentSeason($series, $episode);
            
            $episodeData = $this->prepareEpisodeData($episode, $currentSeason);
            $seriesData = $this->prepareSeriesData($series, $currentSeason);
            
            $this->incrementViewCount($episode);
            
            $nextEpisode = $this->getNextEpisode($seriesId, $episode);
            
            $seasons = Season::where('series_id', $seriesId)
                ->orderBy('season_number')
                ->pluck('season_number')
                ->unique()
                ->values()
                ->all();
                
            $seasonEpisodes = $this->getSeasonEpisodes($seriesId, $currentSeason);
            
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

    private function getEpisodeToDisplay($series, $episodeId = null)
    {
        if ($episodeId) {
            try {
                $episode = Episode::with('content')->findOrFail($episodeId);
                
                return $episode;
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                Log::warning('Épisode non trouvé, utilisation du premier épisode de la série', [
                    'series_id' => $series->id,
                    'requested_episode_id' => $episodeId
                ]);
            }
        }
        
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

    private function getCurrentSeason($series, $episode)
    {
        if ($series->seasons instanceof \Illuminate\Database\Eloquent\Collection) {
            $currentSeason = $series->seasons->first(function ($season) use ($episode) {
                return $season->episodes->contains('id', $episode->id);
            });
            
            if ($currentSeason) {
                return $currentSeason;
            }
        }
        
        $currentSeason = Season::where('series_id', $series->id)
                            ->where('season_number', $episode->season_number)
                            ->first();
                            
        if (!$currentSeason) {
            abort(404, 'Saison non trouvée');
        }
        
        return $currentSeason;
    }

    private function prepareEpisodeData($episode, $currentSeason)
    {
        $contentFiles = $episode->content->contentFiles ?? collect([]);
        $firstFile = $contentFiles->first();
        $filePath = $firstFile ? $firstFile->file_path : null;
        
        if (!$filePath && !empty($episode->file_path)) {
            $filePath = $episode->file_path;
        }
        
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

    private function getNextEpisode($seriesId, $episode)
    {
        $nextEpisode = Episode::where('series_id', $seriesId)
            ->where('season_number', $episode->season_number)
            ->where('episode_number', '>', $episode->episode_number)
            ->orderBy('episode_number')
            ->first();
            
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

    private function incrementViewCount($episode)
    {
        if ($episode->content) {
            $content = Content::find($episode->content->id);
            if ($content) {
                $content->views_count = ($content->views_count ?? 0) + 1;
                $content->save();
            }
        }
        
        Log::info("Épisode {$episode->id} visionné", [
            'user_id' => auth()->id() ?? 'guest',
            'series_id' => $episode->series_id,
            'episode_id' => $episode->id
        ]);
    }



    public function showSeries($seriesId)
    {
        try {
            $seriesId = (int)$seriesId;
            
            $series = $this->seriesRepository->findById($seriesId, ['content', 'seasons.episodes']);
            
            if (!$series) {
                abort(404, 'Série non trouvée');
            }
            
            $firstSeason = $series->seasons()->first();
            if (!$firstSeason) {
                abort(404, 'Aucune saison disponible pour cette série');
            }
            
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
                
            $seasons = Season::where('series_id', $seriesId)
                ->orderBy('season_number')
                ->pluck('season_number')
                ->unique()
                ->values()
                ->all();
                
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

    public function downloadEpisode($seriesId, $episodeId)
    {
        try {
            // Vérifier si l'utilisateur a un rôle Premium
            if (!auth()->check()){
                return redirect()->route('pricing')
                    ->with('error', 'Le téléchargement est réservé aux utilisateurs Premium.');
            }

            // Utilisation du repository pour le téléchargement
            $response = $this->seriesRepository->downloadEpisode($episodeId);
            
            if (!$response) {
                return redirect()->back()
                    ->with('error', 'Le fichier demandé n\'est pas disponible pour le téléchargement.');
            }
            
            return $response;
            
        } catch (\Exception $e) {
            Log::error('Erreur lors du téléchargement d\'épisode', [
                'series_id' => $seriesId,
                'episode_id' => $episodeId,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(), // Ajout de la trace pour plus de détails
                'timestamp' => now(), // Ajout de l'horodatage pour le suivi
            ]);
            
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors du téléchargement. Veuillez réessayer ou contacter le support.');
        }
    }
    
}