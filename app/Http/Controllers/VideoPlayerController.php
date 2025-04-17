<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Series;
use App\Models\Episode;
use App\Models\Movie;
use App\Services\SeriesService;
use Illuminate\Support\Facades\Log;
use App\Models\Content;

class VideoPlayerController extends BaseController
{
    /**
     * @var SeriesService
     */
    protected $seriesService;

    /**
     * VideoPlayerController constructor.
     *
     * @param SeriesService $seriesService
     */
    public function __construct(SeriesService $seriesService)
    {
        $this->seriesService = $seriesService;
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
            // Récupérer la série avec son contenu
            $series = Series::with(['content', 'seasons.episodes'])->findOrFail($seriesId);
            
            if (!$series) {
                abort(404, 'Série non trouvée');
            }
            
            // Déterminer l'épisode à afficher
            $episode = null;
            if ($episodeId) {
                // Récupérer l'épisode spécifié
                $episode = Episode::with('content')->findOrFail($episodeId);
                if (!$episode || !$series->seasons->flatMap->episodes->contains('id', $episode->id)) {
                    abort(404, 'Épisode non trouvé dans cette série');
                }
            } else {
                // Par défaut, afficher le premier épisode de la série
                $episode = $series->seasons->first()->episodes->first();
                if (!$episode) {
                    abort(404, 'Aucun épisode disponible pour cette série');
                }
            }
            
            // Récupérer la saison actuelle
            $currentSeason = $series->seasons->first(function ($season) use ($episode) {
                return $season->episodes->contains('id', $episode->id);
            });
            
            if (!$currentSeason) {
                abort(404, 'Saison non trouvée');
            }
            
            // Préparer les données pour l'affichage
            $episodeData = (object)[
                'id' => $episode->id,
                'title' => $episode->title,
                'thumbnail' => $episode->content->cover_image ?? 'https://via.placeholder.com/640x360',
                'description' => $episode->content->description ?? 'Description non disponible',
                'video_url' => $episode->content->contentFiles->first()->file_path ?? 'https://example.com/episode.mp4',
                'season_number' => $currentSeason->season_number,
                'episode_number' => $episode->episode_number,
                'duration' => $episode->content->duration ?? 45,
                'release_date' => $episode->release_date ?? now()->format('Y-m-d')
            ];
            
            $seriesData = (object)[
                'id' => $series->id,
                'title' => $series->title,
                'poster' => $series->content->cover_image ?? 'https://via.placeholder.com/300x450',
                'seasons' => $series->seasons->map(function ($season) use ($currentSeason) {
                    return (object)[
                        'id' => $season->id,
                        'season_number' => $season->season_number,
                        'is_current' => $season->id === $currentSeason->id,
                        'episodes' => $season->episodes->map(function ($episode) {
                            return (object)[
                                'id' => $episode->id,
                                'title' => $episode->title,
                                'episode_number' => $episode->episode_number,
                                'thumbnail' => $episode->content->cover_image ?? 'https://via.placeholder.com/400x225',
                                'duration' => $episode->content->duration ?? 45
                            ];
                        })
                    ];
                })
            ];
            
            // Incrémenter le nombre de vues
            $episode->content->views_count = ($episode->content->views_count ?? 0) + 1;
            $episode->content->save();
            
            // Log de visionnage
            Log::info("Épisode {$episode->id} visionné", [
                'user_id' => auth()->id() ?? 'guest',
                'series_id' => $seriesId,
                'episode_id' => $episode->id
            ]);
            
            return view('watch.episode', [
                'episode' => $episodeData,
                'series' => $seriesData
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors du chargement de l\'épisode: ' . $e->getMessage());
            abort(500, 'Une erreur est survenue lors du chargement de l\'épisode');
        }
    }

    /**
     * Afficher la page de visionnage d'un film
     *
     * @param  int  $movieId
     * @return \Illuminate\View\View
     */
    public function watchMovie($movieId)
    {
        try {
            // Récupérer le film avec son contenu et ses acteurs
            $movie = Movie::with(['content', 'content.categories', 'actors'])
                ->findOrFail($movieId);
            
            if (!$movie) {
                abort(404, 'Film non trouvé');
            }
            
            // Préparer les données pour l'affichage
            $movieData = (object)[
                'id' => $movie->id,
                'title' => $movie->title,
                'poster' => $movie->content->cover_image ?? 'https://via.placeholder.com/300x450',
                'description' => $movie->content->description ?? 'Description non disponible',
                'release_year' => $movie->content->release_year ?? date('Y', strtotime($movie->release_date)),
                'duration' => $movie->content->duration ?? 120,
                'age_rating' => $movie->content->maturity_rating ?? '12+',
                'rating' => $movie->content->getAverageRatingAttribute() ?? 0,
                'director' => 'Non spécifié', // Ces informations ne sont pas encore dans le modèle
                'writer' => 'Non spécifié',
                'video_url' => $movie->content->contentFiles->first()->file_path ?? 'https://example.com/movie.mp4',
                'categories' => $movie->content->categories ?? collect([]),
                'actors' => $movie->actors ?? collect([])
            ];
            
            // Incrémenter le nombre de vues
            $movie->content->views_count = ($movie->content->views_count ?? 0) + 1;
            $movie->content->save();
            
            // Récupérer des films similaires (même catégorie)
            $similarMovies = collect();
            if ($movie->content->categories->isNotEmpty()) {
                $categoryIds = $movie->content->categories->pluck('id');
                $similarContents = Content::whereHas('categories', function($query) use ($categoryIds) {
                    $query->whereIn('categories.id', $categoryIds);
                })
                ->where('id', '!=', $movie->content->id)
                ->where('type', 'movie')
                ->with('movie')
                ->take(6)
                ->get();
                
                foreach ($similarContents as $content) {
                    if ($content->movie) {
                        $similarMovies->push((object)[
                            'id' => $content->movie->id,
                            'title' => $content->title,
                            'poster' => $content->cover_image ?? 'https://via.placeholder.com/300x450',
                            'release_year' => $content->release_year,
                            'duration' => $content->duration ?? 120
                        ]);
                    }
                }
            }
            
            // Si pas assez de films similaires, compléter avec des films récents
            if ($similarMovies->count() < 6) {
                $recentMovies = Movie::with('content')
                    ->whereHas('content', function($query) use ($movie) {
                        $query->where('id', '!=', $movie->content->id);
                    })
                    ->latest()
                    ->take(6 - $similarMovies->count())
                    ->get();
                
                foreach ($recentMovies as $recentMovie) {
                    $similarMovies->push((object)[
                        'id' => $recentMovie->id,
                        'title' => $recentMovie->content->title ?? $recentMovie->title,
                        'poster' => $recentMovie->content->cover_image ?? 'https://via.placeholder.com/300x450',
                        'release_year' => $recentMovie->content->release_year ?? date('Y', strtotime($recentMovie->release_date)),
                        'duration' => $recentMovie->content->duration ?? 120
                    ]);
                }
            }
            
            // Log de visionnage
            Log::info("Film {$movie->id} visionné", [
                'user_id' => auth()->id() ?? 'guest',
                'movie_id' => $movieId
            ]);
            
            return view('watch.movie', [
                'movie' => $movieData,
                'similarMovies' => $similarMovies
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors du chargement du film: ' . $e->getMessage());
            abort(500, 'Une erreur est survenue lors du chargement du film');
        }
    }

    /**
     * Télécharger un épisode de série
     *
     * @param int $seriesId
     * @param int $episodeId
     * @param string|null $quality
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadEpisode($seriesId, $episodeId, Request $request)
    {
        try {
            // Récupérer l'épisode et la série avec les relations nécessaires
            $episode = Episode::with('content.contentFiles')->findOrFail($episodeId);
            $series = Series::findOrFail($seriesId);
            
            // Vérifier que l'épisode appartient bien à la série
            $episodeBelongsToSeries = $series->seasons()->whereHas('episodes', function($query) use ($episodeId) {
                $query->where('id', $episodeId);
            })->exists();
            
            if (!$episodeBelongsToSeries) {
                Log::warning("Tentative de téléchargement d'un épisode qui n'appartient pas à la série: Episode ID $episodeId, Series ID $seriesId");
                return redirect()->back()->with('error', 'Épisode non trouvé pour cette série');
            }
            
            // Vérifier que l'épisode a un contenu
            if (!$episode->content) {
                Log::warning("Tentative de téléchargement d'un épisode sans contenu: Episode ID $episodeId");
                return redirect()->back()->with('error', 'Contenu non disponible pour cet épisode');
            }
            
            // Récupérer les fichiers disponibles
            $contentFiles = $episode->content->contentFiles;
            
            // Vérifier qu'il y a au moins un fichier disponible
            if ($contentFiles->isEmpty()) {
                Log::warning("Tentative de téléchargement d'un épisode sans fichier: ID $episodeId");
                return redirect()->back()->with('error', 'Aucun fichier disponible pour cet épisode');
            }
            
            // Si une qualité spécifique est demandée, chercher le fichier correspondant
            $contentFile = null;
            $requestedQuality = $request->query('quality');
            
            if ($requestedQuality) {
                $contentFile = $contentFiles->where('quality', $requestedQuality)->first();
                
                // Si la qualité demandée n'existe pas, utiliser le premier fichier disponible
                if (!$contentFile) {
                    Log::warning("Qualité demandée non disponible: $requestedQuality pour l'épisode ID $episodeId");
                    $contentFile = $contentFiles->first();
                }
            } else {
                // Si aucune qualité n'est spécifiée, utiliser le premier fichier
                $contentFile = $contentFiles->first();
            }
            
            // Vérifier que le fichier sélectionné a un chemin valide
            if (empty($contentFile->file_path)) {
                Log::warning("Fichier sans chemin valide pour l'épisode: ID $episodeId");
                return redirect()->back()->with('error', 'Fichier invalide');
            }
            
            // Construire le chemin complet vers le fichier
            $filePath = storage_path('app/public/' . $contentFile->file_path);
            
            // Vérifier que le fichier existe physiquement
            if (!file_exists($filePath)) {
                Log::error("Fichier inexistant pour le téléchargement de l'épisode: $filePath");
                return redirect()->back()->with('error', 'Le fichier n\'existe pas sur le serveur');
            }
            
            // Log de l'action
            Log::info("Téléchargement de l'épisode $episodeId de la série $seriesId", [
                'user_id' => auth()->id() ?? 'guest',
                'episode_id' => $episodeId,
                'series_id' => $seriesId,
                'file_path' => $contentFile->file_path,
                'quality' => $contentFile->quality,
                'ip_address' => request()->ip()
            ]);
            
            // Créer un enregistrement de téléchargement si l'utilisateur est connecté
            if (auth()->check()) {
                \App\Models\Download::create([
                    'content_id' => $episode->content->id,
                    'user_id' => auth()->id(),
                    'download_date' => now(),
                    'ip_address' => request()->ip()
                ]);
            }
            
            // Générer un nom de fichier propre incluant la qualité
            $seasonNumber = $episode->season_number ?? 'S';
            $episodeNumber = $episode->episode_number ?? 'E';
            $quality = $contentFile->quality ? '-' . $contentFile->quality : '';
            $fileName = str_slug($series->title) . "_S{$seasonNumber}E{$episodeNumber}{$quality}." . pathinfo($filePath, PATHINFO_EXTENSION);
            
            // Retourner le fichier pour téléchargement
            return response()->download($filePath, $fileName);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors du téléchargement de l\'épisode: ' . $e->getMessage(), [
                'episode_id' => $episodeId,
                'series_id' => $seriesId,
                'exception' => $e
            ]);
            return redirect()->back()->with('error', 'Une erreur est survenue lors du téléchargement');
        }
    }

    /**
     * Télécharger un film
     *
     * @param int $movieId
     * @param string|null $quality
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadMovie($movieId, Request $request)
    {
        try {
            // Récupérer le film avec son contenu et ses fichiers
            $movie = Movie::with('content.contentFiles')->findOrFail($movieId);
            
            // Vérifier que le film et son contenu existent
            if (!$movie || !$movie->content) {
                Log::warning("Tentative de téléchargement d'un film inexistant: ID $movieId");
                return redirect()->back()->with('error', 'Film non trouvé');
            }
            
            // Récupérer les fichiers disponibles
            $contentFiles = $movie->content->contentFiles;
            
            // Vérifier qu'il y a au moins un fichier disponible
            if ($contentFiles->isEmpty()) {
                Log::warning("Tentative de téléchargement d'un film sans fichier: ID $movieId");
                return redirect()->back()->with('error', 'Aucun fichier disponible pour ce film');
            }
            
            // Si une qualité spécifique est demandée, chercher le fichier correspondant
            $contentFile = null;
            $requestedQuality = $request->query('quality');
            
            if ($requestedQuality) {
                $contentFile = $contentFiles->where('quality', $requestedQuality)->first();
                
                // Si la qualité demandée n'existe pas, utiliser le premier fichier disponible
                if (!$contentFile) {
                    Log::warning("Qualité demandée non disponible: $requestedQuality pour le film ID $movieId");
                    $contentFile = $contentFiles->first();
                }
            } else {
                // Si aucune qualité n'est spécifiée, utiliser le premier fichier
                $contentFile = $contentFiles->first();
            }
            
            // Vérifier que le fichier sélectionné a un chemin valide
            if (empty($contentFile->file_path)) {
                Log::warning("Fichier sans chemin valide pour le film: ID $movieId");
                return redirect()->back()->with('error', 'Fichier invalide');
            }
            
            // Construire le chemin complet vers le fichier
            $filePath = storage_path('app/public/' . $contentFile->file_path);
            
            // Vérifier que le fichier existe physiquement
            if (!file_exists($filePath)) {
                Log::error("Fichier inexistant pour le téléchargement du film: $filePath");
                return redirect()->back()->with('error', 'Le fichier n\'existe pas sur le serveur');
            }
            
            // Log de l'action
            Log::info("Téléchargement du film $movieId", [
                'user_id' => auth()->id() ?? 'guest',
                'movie_id' => $movieId,
                'file_path' => $contentFile->file_path,
                'quality' => $contentFile->quality,
                'ip_address' => request()->ip()
            ]);
            
            // Créer un enregistrement de téléchargement si l'utilisateur est connecté
            if (auth()->check()) {
                \App\Models\Download::create([
                    'content_id' => $movie->content->id,
                    'user_id' => auth()->id(),
                    'download_date' => now(),
                    'ip_address' => request()->ip()
                ]);
            }
            
            // Générer un nom de fichier propre incluant la qualité
            $quality = $contentFile->quality ? '-' . $contentFile->quality : '';
            $fileName = str_slug($movie->title) . $quality . '.' . pathinfo($filePath, PATHINFO_EXTENSION);
            
            // Retourner le fichier pour téléchargement
            return response()->download($filePath, $fileName);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors du téléchargement du film: ' . $e->getMessage(), [
                'movie_id' => $movieId,
                'exception' => $e
            ]);
            return redirect()->back()->with('error', 'Une erreur est survenue lors du téléchargement');
        }
    }
} 