<?php

namespace App\Repositories;

use App\Models\Series;
use App\Models\Episode;
use App\Models\Content;
use App\Repositories\Interfaces\SeriesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SeriesRepository implements SeriesRepositoryInterface
{
    /**
     * Get all series
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Series::with(['content', 'content.categories', 'content.tags'])->get();
    }

    /**
     * Get paginated series
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Series::with('content')->paginate($perPage);
    }

    /**
     * Find series by ID
     *
     * @param int $id
     * @param array $relations
     * @return Series|null
     */
    public function findById(int $id, array $relations = []): ?Series
    {
        return Series::with($relations)->find($id);
    }

    /**
     * Create a new series
     *
     * @param array $data
     * @return Series
     */
    public function create(array $data): Series
    {
        return DB::transaction(function () use ($data) {
            // Create content
            $content = Content::create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'release_year' => $data['release_year'] ?? null,
                'maturity_rating' => $data['maturity_rating'] ?? 'PG',
                'cover_image' => $data['cover_image'] ?? null,
                'status' => $data['status'] ?? 'ongoing',
                'type' => 'series',
                'duration' => $data['duration'] ?? 0,
                'views_count' => 0
            ]);

            // Create series
            $series = Series::create([
                'content_id' => $content->id,
                'seasons' => $data['seasons'] ?? 1,
                'total_episodes' => isset($data['episodes']) ? count($data['episodes']) : 0
            ]);

            // Attach categories
            if (!empty($data['categories'])) {
                $content->categories()->attach($data['categories']);
            }

            // Attach tags
            if (!empty($data['tags'])) {
                $content->tags()->attach($data['tags']);
            }

            // Attach actors
            if (!empty($data['actors'])) {
                $series->actors()->attach($data['actors']);
            }

            // Créer automatiquement des objets Season pour cette série
            $numberOfSeasons = $data['seasons'] ?? 1;
            for ($i = 1; $i <= $numberOfSeasons; $i++) {
                $series->seasons()->create([
                    'season_number' => $i,
                    'title' => 'Saison ' . $i,
                    'release_date' => now(),
                ]);
            }

            // Create episodes
            if (!empty($data['episodes'])) {
                foreach ($data['episodes'] as $episodeData) {
                    $series->episodes()->create([
                        'title' => $episodeData['title'],
                        'episode_number' => $episodeData['episode_number'] ?? $episodeData['number'],
                        'season_number' => $episodeData['season_number'] ?? 1,
                        'file_path' => $episodeData['file_path'] ?? null,
                        'release_date' => $episodeData['release_date'] ?? now(),
                        'views_count' => $episodeData['views_count'] ?? 0
                    ]);
                }
            }

            return $series->load(['content', 'episodes', 'actors', 'seasons']);
        });
    }

    /**
     * Update series
     *
     * @param array $data
     * @param int $id
     * @return Series|null
     */
    public function update(array $data, $id): ?Series
    {
        $series = Series::find($id);
        if (!$series) {
            return null;
        }

        return DB::transaction(function () use ($series, $data, $id) {
            // Mise à jour des données de base de la série
            if (isset($data['title']) && $series->content) {
                // Mettre à jour le titre seulement dans le contenu associé
                $series->content->title = $data['title'];
                $series->content->save();
            }

            // Données qui existent vraiment dans la table series
            $seriesDataToUpdate = [];
            
            if (isset($data['total_episodes'])) {
                $seriesDataToUpdate['total_episodes'] = $data['total_episodes'];
            }

            if (isset($data['views_count'])) {
                $seriesDataToUpdate['views_count'] = $data['views_count'];
            }
            
            // Mise à jour du nombre de saisons si spécifié
            if (isset($data['seasons'])) {
                $seriesDataToUpdate['seasons'] = $data['seasons'];
                
                // Mettre à jour les objets Season
                $currentSeasonCount = $series->seasons()->count();
                $newSeasonCount = $data['seasons'];
                
                // Si on a augmenté le nombre de saisons, créer de nouvelles saisons
                if ($newSeasonCount > $currentSeasonCount) {
                    for ($i = $currentSeasonCount + 1; $i <= $newSeasonCount; $i++) {
                        $series->seasons()->create([
                            'season_number' => $i,
                            'title' => 'Saison ' . $i,
                            'release_date' => now(),
                        ]);
                    }
                }
                // Si on a réduit le nombre de saisons, supprimer les saisons en trop
                else if ($newSeasonCount < $currentSeasonCount) {
                    $series->seasons()->where('season_number', '>', $newSeasonCount)->delete();
                }
            }
            
            // Vérifier si la série a au moins une saison, sinon en créer une
            if ($series->seasons()->count() == 0) {
                $series->seasons()->create([
                    'season_number' => 1,
                    'title' => 'Saison 1',
                    'release_date' => now(),
                ]);
                
                if (!isset($seriesDataToUpdate['seasons'])) {
                    $seriesDataToUpdate['seasons'] = 1;
                }
            }
            
            // Mise à jour des attributs de série si nécessaire
            if (!empty($seriesDataToUpdate)) {
                $series->update($seriesDataToUpdate);
            }

            // Mettre à jour les tags
            if (isset($data['tags']) && $series->content) {
                $series->content->tags()->sync($data['tags']);
            }

            // Mettre à jour les catégories
            if (isset($data['categories']) && $series->content) {
                $series->content->categories()->sync($data['categories']);
            }

            // Mettre à jour les acteurs
            if (isset($data['actors'])) {
                $series->actors()->sync($data['actors']);
            }

            // Mettre à jour les descriptions
            if (isset($data['description']) && $series->content) {
                $series->content->description = $data['description'];
                $series->content->save();
            }

            // Mettre à jour l'image de couverture
            if (isset($data['cover_image']) && $series->content) {
                $series->content->cover_image = $data['cover_image'];
                $series->content->save();
            }

            // Traiter les épisodes
            if (isset($data['episodes'])) {
                foreach ($data['episodes'] as $episodeData) {
                    if (isset($episodeData['id']) && !empty($episodeData['id'])) {
                        // Mise à jour d'un épisode existant
                        $episode = Episode::find($episodeData['id']);
                        if ($episode) {
                            $episodeUpdate = [
                                'title' => $episodeData['title'],
                                'episode_number' => $episodeData['episode_number'] ?? $episodeData['number'] ?? $episode->episode_number,
                                'season_number' => $episodeData['season_number'] ?? $episode->season_number,
                            ];

                            // Mise à jour de la série d'appartenance
                            if (isset($episodeData['series_id'])) {
                                $episodeUpdate['series_id'] = $episodeData['series_id'] ?: null;
                            }

                            // Mise à jour du fichier vidéo si fourni
                            if (isset($episodeData['file_path'])) {
                                $episodeUpdate['file_path'] = $episodeData['file_path'];
                            }

                            $episode->update($episodeUpdate);
                        }
                    } else {
                        // Création d'un nouvel épisode
                        $episodeCreate = [
                            'title' => $episodeData['title'],
                            'episode_number' => $episodeData['episode_number'] ?? $episodeData['number'] ?? 1,
                            'season_number' => $episodeData['season_number'] ?? 1,
                            'release_date' => $episodeData['release_date'] ?? now(),
                            'views_count' => $episodeData['views_count'] ?? 0,
                        ];

                        // Définir la série d'appartenance
                        if (isset($episodeData['series_id']) && !empty($episodeData['series_id'])) {
                            // Si une série spécifique est définie
                            $episodeCreate['series_id'] = $episodeData['series_id'];
                            Episode::create($episodeCreate);
                        } else {
                            // Si aucune série n'est définie, l'ajouter à la série actuelle
                            $series->episodes()->create($episodeCreate);
                        }

                        // Gérer le fichier vidéo
                        if (isset($episodeData['file_path'])) {
                            $episodeCreate['file_path'] = $episodeData['file_path'];
                        }
                    }
                }
            }

            // Mettre à jour le nombre total d'épisodes pour cette série
            $totalEpisodes = $series->episodes()->count();
            $series->total_episodes = $totalEpisodes;
            $series->save();

            return $series->load(['content', 'content.categories', 'content.tags', 'episodes', 'actors', 'seasons']);
        });
    }

    /**
     * Delete series
     *
     * @param int $id
     * @return bool
     */
    public function delete($id): bool
    {
        $series = Series::find($id);
        if ($series) {
            return $series->delete();
        }
        return false;
    }

    /**
     * Search series by title
     *
     * @param string $query
     * @return Collection
     */
    public function searchByTitle(string $query): Collection
    {
        return Series::whereHas('content', function ($q) use ($query) {
            $q->where('title', 'like', "%{$query}%");
        })->with('content')->get();
    }

    /**
     * Get series by category
     *
     * @param int $categoryId
     * @return Collection
     */
    public function getByCategory(int $categoryId): Collection
    {
        return Series::whereHas('content.categories', function ($q) use ($categoryId) {
            $q->where('id', $categoryId);
        })->with('content')->get();
    }

    /**
     * Get series by tag
     *
     * @param int $tagId
     * @return Collection
     */
    public function getByTag(int $tagId): Collection
    {
        return Series::whereHas('content.tags', function ($q) use ($tagId) {
            $q->where('id', $tagId);
        })->with('content')->get();
    }

    /**
     * Get series by actor
     *
     * @param int $actorId
     * @return Collection
     */
    public function getByActor(int $actorId): Collection
    {
        return Series::whereHas('actors', function ($q) use ($actorId) {
            $q->where('id', $actorId);
        })->with('content')->get();
    }

    /**
     * Get episodes by season
     *
     * @param int $seriesId
     * @param int $seasonNumber
     * @return Collection
     */
    public function getEpisodesBySeason(int $seriesId, int $seasonNumber): Collection
    {
        return Episode::where('series_id', $seriesId)
            ->where('season_number', $seasonNumber)
            ->orderBy('episode_number')
            ->get();
    }

    /**
     * Get popular series
     *
     * @param int $limit
     * @return Collection
     */
    public function getPopular(int $limit): Collection
    {
        return Series::withCount('episodes')
            ->orderByDesc('views_count')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent series
     *
     * @param int $limit
     * @return Collection
     */
    public function getRecent(int $limit): Collection
    {
        return Series::withCount('episodes')
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }
} 