<?php

namespace App\Repositories;

use App\Models\Series;
use App\Models\Episode;
use App\Models\Content;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SeriesRepository
{
    /**
     * Get all series
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Series::with('content')->get();
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
        // Commencer une transaction pour garantir la cohérence des données
        return DB::transaction(function () use ($data) {
            // 1. D'abord créer l'entrée content
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

            // 2. Créer la série avec le content_id
            $series = Series::create([
                'content_id' => $content->id,
                'seasons' => $data['seasons'] ?? 1,
                'total_episodes' => isset($data['episodes']) ? count($data['episodes']) : 0
            ]);

            // 3. Ajouter des catégories (si présentes)
            if (!empty($data['categories'])) {
                $content->categories()->attach($data['categories']);
            }

            // 4. Ajouter des tags (si présents)
            if (!empty($data['tags'])) {
                $content->tags()->attach($data['tags']);
            }

            // 5. Ajouter des acteurs (si présents)
            if (!empty($data['actors'])) {
                $series->actors()->attach($data['actors']);
            }

            // 6. Ajouter des épisodes (si présents)
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

            // Charger les relations pour le retour
            return $series->load(['content', 'episodes', 'actors']);
        });
    }

    /**
     * Update series
     *
     * @param array $data
     * @param int $id
     * @return Series|null
     */
    public function update(array $data, int $id): ?Series
    {
        $series = Series::find($id);
        if ($series) {
            $series->update($data);
            return $series;
        }
        return null;
    }

    /**
     * Delete series
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
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
        return Series::whereHas('content', function ($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
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
            $q->where('tag_id', $tagId);
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
            $q->where('actor_id', $actorId);
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
    public function getPopular(int $limit = 10): Collection
    {
        return Series::whereHas('content', function ($q) {
            $q->orderBy('views', 'desc');
        })->with('content')->limit($limit)->get();
    }

    /**
     * Get recent series
     *
     * @param int $limit
     * @return Collection
     */
    public function getRecent(int $limit = 10): Collection
    {
        return Series::whereHas('content', function ($q) {
            $q->orderBy('created_at', 'desc');
        })->with('content')->limit($limit)->get();
    }
} 