<?php

namespace App\Services;

use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class SeriesService
{
    /**
     * @var SeriesRepository
     */
    private $seriesRepository;
    
    /**
     * SeriesService constructor.
     *
     * @param SeriesRepository $seriesRepository
     */
    public function __construct(SeriesRepository $seriesRepository)
    {
        $this->seriesRepository = $seriesRepository;
    }

    /**
     * Get all series
     *
     * @return Collection
     */
    public function getAllSeries(): Collection
    {
        return $this->seriesRepository->getAll();
    }

    /**
     * Get paginated series
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedSeries(int $perPage = 10): LengthAwarePaginator
    {
        return $this->seriesRepository->getPaginated($perPage);
    }

    /**
     * Find series by ID
     *
     * @param int $id
     * @param array $relations
     * @return Series|null
     */
    public function findSeriesById(int $id, array $relations = []): ?Series
    {
        return $this->seriesRepository->findById($id, $relations);
    }

    /**
     * Create new series with all related entities
     *
     * @param array $data
     * @return Series
     */
    public function createSeries(array $data): Series
    {
        try {
            return $this->seriesRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error creating series: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update series with all related entities
     *
     * @param int $id
     * @param array $data
     * @return Series|null
     */
    public function updateSeries(int $id, array $data): ?Series
    {
        try {
            return $this->seriesRepository->update($data, $id);
        } catch (\Exception $e) {
            Log::error('Error updating series: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete series and all related entities
     *
     * @param int $id
     * @return bool
     */
    public function deleteSeries(int $id): bool
    {
        try {
            return $this->seriesRepository->delete($id);
        } catch (\Exception $e) {
            Log::error('Error deleting series: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Search series by title
     *
     * @param string $query
     * @return Collection
     */
    public function searchSeriesByTitle(string $query): Collection
    {
        return $this->seriesRepository->searchByTitle($query);
    }

    /**
     * Get series by category
     *
     * @param int $categoryId
     * @return Collection
     */
    public function getSeriesByCategory(int $categoryId): Collection
    {
        return $this->seriesRepository->getByCategory($categoryId);
    }

    /**
     * Get series by tag
     *
     * @param int $tagId
     * @return Collection
     */
    public function getSeriesByTag(int $tagId): Collection
    {
        return $this->seriesRepository->getByTag($tagId);
    }

    /**
     * Get series by actor
     *
     * @param int $actorId
     * @return Collection
     */
    public function getSeriesByActor(int $actorId): Collection
    {
        return $this->seriesRepository->getByActor($actorId);
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
        return $this->seriesRepository->getEpisodesBySeason($seriesId, $seasonNumber);
    }

    /**
     * Get popular series
     *
     * @param int $limit
     * @return Collection
     */
    public function getPopularSeries(int $limit = 10): Collection
    {
        return $this->seriesRepository->getPopular($limit);
    }

    /**
     * Get recent series
     *
     * @param int $limit
     * @return Collection
     */
    public function getRecentSeries(int $limit = 10): Collection
    {
        return $this->seriesRepository->getRecent($limit);
    }
}