<?php

namespace App\Repositories\Interfaces;

use App\Models\Series;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface SeriesRepositoryInterface
{
    // CRUD operations (all handle relations)
    public function getAll(): Collection;
    public function getPaginated(int $perPage): LengthAwarePaginator;
    public function findById(int $id, array $relations = []): ?Series;
    public function create(array $data): Series;
    public function update(array $data, $id): ?Series;
    public function delete($id): bool;
    
    // Search methods
    public function searchByTitle(string $query): Collection;
    public function getByCategory(int $categoryId): Collection;
    public function getByTag(int $tagId): Collection;
    public function getByActor(int $actorId): Collection;
    public function getEpisodesBySeason(int $seriesId, int $seasonNumber): Collection;
    
    // Sorting/filtering methods
    public function getPopular(int $limit): Collection;
    public function getRecent(int $limit): Collection;

    public function downloadEpisode(int $seriesId);
}