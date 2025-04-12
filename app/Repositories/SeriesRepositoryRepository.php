<?php

namespace App\Repositories;

use App\Models\Series;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SeriesRepositoryRepository.
 *
 * @package namespace App\Repositories;
 */
interface SeriesRepositoryRepository extends RepositoryInterface
{
    /**
     * Get all series
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get paginated series
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage): LengthAwarePaginator;

    /**
     * Find series by ID with related entities
     *
     * @param int $id
     * @param array $relations Relationships to eager load
     * @return Series|null
     */
    public function findById(int $id, array $relations = []): ?Series;

    /**
     * Create a new entity with relationships
     *
     * @param array $data
     * @return Series
     */
    public function create(array $data): Series;

    /**
     * Update series with all related entities
     *
     * @param array $data Series data including relations
     * @param int $id
     * @return Series|null
     */
    public function update(array $data, $id): ?Series;

    /**
     * Delete a series and all related entities
     *
     * @param $id
     * @return bool
     */
    public function delete($id): bool;

    /**
     * Search series by title
     *
     * @param string $query
     * @return Collection
     */
    public function searchByTitle(string $query): Collection;

    /**
     * Get series by category
     *
     * @param int $categoryId
     * @return Collection
     */
    public function getByCategory(int $categoryId): Collection;

    /**
     * Get series by tag
     * 
     * @param int $tagId
     * @return Collection
     */
    public function getByTag(int $tagId): Collection;

    /**
     * Get series by actor
     *
     * @param int $actorId
     * @return Collection
     */
    public function getByActor(int $actorId): Collection;

    /**
     * Get episodes by series and season
     *
     * @param int $seriesId
     * @param int $seasonNumber
     * @return Collection
     */
    public function getEpisodesBySeason(int $seriesId, int $seasonNumber): Collection;

    /**
     * Get popular series
     *
     * @param int $limit
     * @return Collection
     */
    public function getPopular(int $limit): Collection;

    /**
     * Get recent series
     *
     * @param int $limit
     * @return Collection
     */
    public function getRecent(int $limit): Collection;
}
