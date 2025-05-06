<?php

namespace App\Services;

use App\Models\Series;
use App\Repositories\Interfaces\SeriesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class SeriesService
{
    private $seriesRepository;
    
    public function __construct(SeriesRepositoryInterface $seriesRepository)
    {
        $this->seriesRepository = $seriesRepository;
    }

    public function getAllSeries(): Collection
    {
        return $this->seriesRepository->getAll();
    }

    public function getPaginatedSeries(int $perPage = 10): LengthAwarePaginator
    {
        return $this->seriesRepository->getPaginated($perPage);
    }

    public function findSeriesById(int $id, array $relations = []): ?Series
    {
        return $this->seriesRepository->findById($id, $relations);
    }

    public function createSeries(array $data): Series
    {
        try {
            return $this->seriesRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error creating series: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateSeries(int $id, array $data): ?Series
    {
        try {
            return $this->seriesRepository->update($data, $id);
        } catch (\Exception $e) {
            Log::error('Error updating series: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteSeries(int $id): bool
    {
        try {
            return $this->seriesRepository->delete($id);
        } catch (\Exception $e) {
            Log::error('Error deleting series: ' . $e->getMessage());
            throw $e;
        }
    }

    public function searchSeriesByTitle(string $query): Collection
    {
        return $this->seriesRepository->searchByTitle($query);
    }

    public function getSeriesByCategory(int $categoryId): Collection
    {
        return $this->seriesRepository->getByCategory($categoryId);
    }

    public function getSeriesByTag(int $tagId): Collection
    {
        return $this->seriesRepository->getByTag($tagId);
    }

    public function getSeriesByActor(int $actorId): Collection
    {
        return $this->seriesRepository->getByActor($actorId);
    }

    public function getEpisodesBySeason(int $seriesId, int $seasonNumber): Collection
    {
        return $this->seriesRepository->getEpisodesBySeason($seriesId, $seasonNumber);
    }

    public function getPopularSeries(int $limit = 10): Collection
    {
        return $this->seriesRepository->getPopular($limit);
    }

    public function getRecentSeries(int $limit = 10): Collection
    {
        return $this->seriesRepository->getRecent($limit);
    }

    public function getAllSeriesWithRelations(): array
    {
        $series = $this->seriesRepository->getAll();
        
        return $series->map(function ($series) {
            return [
                'id' => $series->id,
                'title' => $series->content->title ?? '',
                'description' => $series->content->description ?? '',
                'cover_image' => $series->content->cover_image ?? '/images/default-cover.jpg',
                'categories' => $series->content->categories->pluck('name') ?? [],
                'tags' => $series->content->tags->pluck('name') ?? [],
            ];
        })->toArray();
    }
}