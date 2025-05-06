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
    public function getAll(): Collection
    {
        return Series::with(['content', 'content.categories', 'content.tags'])->get();
    }

    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Series::with('content')->paginate($perPage);
    }

    public function findById(int $id, array $relations = []): ?Series
    {
        return Series::with($relations)->find($id);
    }

    public function create(array $data): Series
    {
        return DB::transaction(function () use ($data) {
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

            $series = Series::create([
                'content_id' => $content->id,
                'seasons' => $data['seasons'] ?? 1,
                'total_episodes' => isset($data['episodes']) ? count($data['episodes']) : 0
            ]);

            if (!empty($data['categories'])) {
                $content->categories()->attach($data['categories']);
            }

            if (!empty($data['tags'])) {
                $content->tags()->attach($data['tags']);
            }

            if (!empty($data['actors'])) {
                $series->actors()->attach($data['actors']);
            }

            $numberOfSeasons = $data['seasons'] ?? 1;
            for ($i = 1; $i <= $numberOfSeasons; $i++) {
                $series->seasons()->create([
                    'season_number' => $i,
                    'title' => 'Saison ' . $i,
                    'release_date' => now(),
                ]);
            }

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

    public function update(array $data, $id): ?Series
    {
        $series = Series::find($id);
        if (!$series) {
            return null;
        }

        return DB::transaction(function () use ($series, $data, $id) {
            if (isset($data['title']) && $series->content) {
                $series->content->title = $data['title'];
                $series->content->save();
            }

            $seriesDataToUpdate = [];

            if (isset($data['total_episodes'])) {
                $seriesDataToUpdate['total_episodes'] = $data['total_episodes'];
            }

            if (isset($data['views_count'])) {
                $seriesDataToUpdate['views_count'] = $data['views_count'];
            }

            if (isset($data['seasons'])) {
                $seriesDataToUpdate['seasons'] = $data['seasons'];

                $currentSeasonCount = $series->seasons()->count();
                $newSeasonCount = $data['seasons'];

                if ($newSeasonCount > $currentSeasonCount) {
                    for ($i = $currentSeasonCount + 1; $i <= $newSeasonCount; $i++) {
                        $series->seasons()->create([
                            'season_number' => $i,
                            'title' => 'Saison ' . $i,
                            'release_date' => now(),
                        ]);
                    }
                } else if ($newSeasonCount < $currentSeasonCount) {
                    $series->seasons()->where('season_number', '>', $newSeasonCount)->delete();
                }
            }

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

            if (!empty($seriesDataToUpdate)) {
                $series->update($seriesDataToUpdate);
            }

            if (isset($data['tags']) && $series->content) {
                $series->content->tags()->sync($data['tags']);
            }

            if (isset($data['categories']) && $series->content) {
                $series->content->categories()->sync($data['categories']);
            }

            if (isset($data['actors'])) {
                $series->actors()->sync($data['actors']);
            }

            if (isset($data['description']) && $series->content) {
                $series->content->description = $data['description'];
                $series->content->save();
            }

            if (isset($data['cover_image']) && $series->content) {
                $series->content->cover_image = $data['cover_image'];
                $series->content->save();
            }

            if (isset($data['episodes'])) {
                foreach ($data['episodes'] as $episodeData) {
                    if (isset($episodeData['id']) && !empty($episodeData['id'])) {
                        $episode = Episode::find($episodeData['id']);
                        if ($episode) {
                            $episodeUpdate = [
                                'title' => $episodeData['title'],
                                'episode_number' => $episodeData['episode_number'] ?? $episodeData['number'] ?? $episode->episode_number,
                                'season_number' => $episodeData['season_number'] ?? $episode->season_number,
                            ];

                            if (isset($episodeData['series_id'])) {
                                $episodeUpdate['series_id'] = $episodeData['series_id'] ?: null;
                            }

                            if (isset($episodeData['file_path'])) {
                                $episodeUpdate['file_path'] = $episodeData['file_path'];
                            }

                            $episode->update($episodeUpdate);
                        }
                    } else {
                        $episodeCreate = [
                            'title' => $episodeData['title'],
                            'episode_number' => $episodeData['episode_number'] ?? $episodeData['number'] ?? 1,
                            'season_number' => $episodeData['season_number'] ?? 1,
                            'release_date' => $episodeData['release_date'] ?? now(),
                            'views_count' => $episodeData['views_count'] ?? 0,
                        ];

                        if (isset($episodeData['series_id']) && !empty($episodeData['series_id'])) {
                            $episodeCreate['series_id'] = $episodeData['series_id'];
                            Episode::create($episodeCreate);
                        } else {
                            $series->episodes()->create($episodeCreate);
                        }

                        if (isset($episodeData['file_path'])) {
                            $episodeCreate['file_path'] = $episodeData['file_path'];
                        }
                    }
                }
            }

            $totalEpisodes = $series->episodes()->count();
            $series->total_episodes = $totalEpisodes;
            $series->save();

            return $series->load(['content', 'content.categories', 'content.tags', 'episodes', 'actors', 'seasons']);
        });
    }

    public function delete($id): bool
    {
        $series = Series::find($id);
        if ($series) {
            return $series->delete();
        }
        return false;
    }

    public function searchByTitle(string $query): Collection
    {
        return Series::whereHas('content', function ($q) use ($query) {
            $q->where('title', 'like', "%{$query}%");
        })->with('content')->get();
    }

    public function getByCategory(int $categoryId): Collection
    {
        return Series::whereHas('content.categories', function ($q) use ($categoryId) {
            $q->where('id', $categoryId);
        })->with('content')->get();
    }

    public function getByTag(int $tagId): Collection
    {
        return Series::whereHas('content.tags', function ($q) use ($tagId) {
            $q->where('id', $tagId);
        })->with('content')->get();
    }

    public function getByActor(int $actorId): Collection
    {
        return Series::whereHas('actors', function ($q) use ($actorId) {
            $q->where('id', $actorId);
        })->with('content')->get();
    }

    public function getEpisodesBySeason(int $seriesId, int $seasonNumber): Collection
    {
        return Episode::where('series_id', $seriesId)
            ->where('season_number', $seasonNumber)
            ->orderBy('episode_number')
            ->get();
    }

    public function getPopular(int $limit): Collection
    {
        return Series::withCount('episodes')
            ->orderByDesc('views_count')
            ->limit($limit)
            ->get();
    }

    public function getRecent(int $limit): Collection
    {
        return Series::withCount('episodes')
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    public function downloadEpisode($episodeId)
    {
        $episode = Episode::with('content')->find($episodeId);

        if (!$episode) {
            return null;
        }

        if (empty($episode->file_path)) {
            return null;
        }

        $possiblePaths = [
            storage_path('app/' . $episode->file_path),
            storage_path('app/public/' . $episode->file_path),
            public_path('storage/' . $episode->file_path),
            public_path($episode->file_path)
        ];

        $filePath = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $filePath = $path;
                break;
            }
        }

        if (!$filePath) {
            return null;
        }

        $fileName = \Illuminate\Support\Str::slug($episode->title) . '-' . $episode->season_number . 'x' . $episode->episode_number . '.mp4';

        return response()->download($filePath, $fileName);
    }
}