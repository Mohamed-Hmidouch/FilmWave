<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SeriesRepositoryRepository;
use App\Repositories\Interfaces\SeriesRepositoryInterface;
use App\Entities\SeriesRepository;
use App\Models\Series;
use App\Models\Content;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Actor;
use App\Models\Episode;
use App\Validators\SeriesRepositoryValidator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class SeriesRepositoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SeriesRepositoryRepositoryEloquent extends BaseRepository implements SeriesRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Series::class;
    }

    /**
     * Get all series
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get paginated series
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    /**
     * Find series by ID with related entities
     *
     * @param int $id
     * @param array $relations Relationships to eager load
     * @return Series|null
     */
    public function findById(int $id, array $relations = []): ?Series
    {
        $query = $this->model->where('id', $id);
        
        if (!empty($relations)) {
            $query->with($relations);
        }
        
        return $query->first();
    }

    /**
     * Create a new series with all related entities
     *
     * @param array $data Series data including relations
     * @return Series
     */
    public function create(array $data): Series
    {
        DB::beginTransaction();
        
        try {
            // 1. Create content first
            $contentData = [
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'release_year' => $data['release_year'] ?? null,
                'duration' => $data['duration'] ?? 0,
                'type' => 'series',
                'cover_image' => $data['cover_image'] ?? null,
                'maturity_rating' => $data['maturity_rating'] ?? null,
                'views_count' => 0
            ];
            
            $content = Content::create($contentData);
            
            // 2. Create the series
            $seriesData = [
                'content_id' => $content->id,
                'seasons' => $data['seasons'] ?? 1,
                'total_episodes' => $data['total_episodes'] ?? 0,
                'status' => $data['status'] ?? 'ongoing',
                'average_episode_length' => $data['average_episode_length'] ?? null,
            ];
            
            $series = $this->model->create($seriesData);
            
            // 3. Associate tags if provided
            if (!empty($data['tags'])) {
                $content->tags()->sync($data['tags']);
            }
            
            // 4. Associate categories if provided
            if (!empty($data['categories'])) {
                $content->categories()->sync($data['categories']);
            }
            
            // 5. Associate actors if provided
            if (!empty($data['actors'])) {
                $series->actors()->sync($data['actors']);
            }
            
            // 6. Create episodes if provided
            if (!empty($data['episodes'])) {
                foreach ($data['episodes'] as $episodeData) {
                    $episode = new Episode([
                        'title' => $episodeData['title'],
                        'description' => $episodeData['description'] ?? null,
                        'season_number' => $episodeData['season_number'],
                        'episode_number' => $episodeData['episode_number'],
                        'file_path' => $episodeData['file_path'] ?? null,
                        'release_date' => $episodeData['release_date'] ?? now(),
                        'views_count' => 0
                    ]);
                    
                    $series->episodes()->save($episode);
                }
                
                // Update total episodes count
                $series->update(['total_episodes' => count($data['episodes'])]);
            }
            
            DB::commit();
            return $series;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Update series with all related entities
     *
     * @param array $data Series data including relations
     * @param $id
     * @return Series|null
     */
    public function update(array $data, $id): ?Series
    {
        $series = $this->findById($id, ['content']);
        
        if (!$series) {
            return null;
        }
        
        DB::beginTransaction();
        
        try {
            // 1. Update content
            if ($series->content) {
                $contentData = [];
                
                if (isset($data['title'])) $contentData['title'] = $data['title'];
                if (isset($data['description'])) $contentData['description'] = $data['description'];
                if (isset($data['release_year'])) $contentData['release_year'] = $data['release_year'];
                if (isset($data['duration'])) $contentData['duration'] = $data['duration'];
                if (isset($data['maturity_rating'])) $contentData['maturity_rating'] = $data['maturity_rating'];
                
                // Handle cover image
                if (isset($data['cover_image']) && $data['cover_image'] !== $series->content->cover_image) {
                    // Delete old cover if exists
                    if ($series->content->cover_image) {
                        Storage::delete('public/' . $series->content->cover_image);
                    }
                    $contentData['cover_image'] = $data['cover_image'];
                }
                
                $series->content->update($contentData);
            }
            
            // 2. Update series
            $seriesData = [];
            if (isset($data['seasons'])) $seriesData['seasons'] = $data['seasons'];
            if (isset($data['status'])) $seriesData['status'] = $data['status'];
            if (isset($data['average_episode_length'])) $seriesData['average_episode_length'] = $data['average_episode_length'];
            
            $series->update($seriesData);
            
            // 3. Update tags
            if (isset($data['tags'])) {
                $series->content->tags()->sync($data['tags']);
            }
            
            // 4. Update categories
            if (isset($data['categories'])) {
                $series->content->categories()->sync($data['categories']);
            }
            
            // 5. Update actors
            if (isset($data['actors'])) {
                $series->actors()->sync($data['actors']);
            }
            
            // 6. Update episodes
            if (isset($data['episodes'])) {
                // Delete episodes that aren't in the new data
                $existingEpisodeIds = array_column($data['episodes'], 'id');
                $existingEpisodeIds = array_filter($existingEpisodeIds); // Remove empty values
                
                if (!empty($existingEpisodeIds)) {
                    $series->episodes()->whereNotIn('id', $existingEpisodeIds)->delete();
                }
                
                // Update or create episodes
                foreach ($data['episodes'] as $episodeData) {
                    if (isset($episodeData['id'])) {
                        // Update existing episode
                        $episode = Episode::find($episodeData['id']);
                        if ($episode) {
                            $episode->update([
                                'title' => $episodeData['title'],
                                'description' => $episodeData['description'] ?? $episode->description,
                                'season_number' => $episodeData['season_number'] ?? $episode->season_number,
                                'episode_number' => $episodeData['episode_number'] ?? $episode->episode_number,
                                'file_path' => $episodeData['file_path'] ?? $episode->file_path,
                                'release_date' => $episodeData['release_date'] ?? $episode->release_date
                            ]);
                        }
                    } else {
                        // Create new episode
                        $episode = new Episode([
                            'title' => $episodeData['title'],
                            'description' => $episodeData['description'] ?? null,
                            'season_number' => $episodeData['season_number'],
                            'episode_number' => $episodeData['episode_number'],
                            'file_path' => $episodeData['file_path'] ?? null,
                            'release_date' => $episodeData['release_date'] ?? now(),
                            'views_count' => 0
                        ]);
                        
                        $series->episodes()->save($episode);
                    }
                }
                
                // Update total episodes count
                $series->update(['total_episodes' => $series->episodes()->count()]);
            }
            
            DB::commit();
            return $series->fresh(['content', 'episodes', 'actors']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete a series and all related entities
     *
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $series = $this->findById($id, ['content', 'episodes']);
        
        if (!$series) {
            return false;
        }
        
        DB::beginTransaction();
        
        try {
            // 1. Delete episodes
            foreach ($series->episodes as $episode) {
                // Delete episode files if they exist
                if ($episode->file_path) {
                    Storage::delete('public/' . $episode->file_path);
                }
                
                $episode->delete();
            }
            
            // 2. Remove actor relationships
            $series->actors()->detach();
            
            // 3. Delete the content (which will cascade delete tags and categories relationships)
            if ($series->content) {
                // Delete cover image if exists
                if ($series->content->cover_image) {
                    Storage::delete('public/' . $series->content->cover_image);
                }
                
                $series->content->delete();
            }
            
            // 4. Delete the series itself
            $series->delete();
            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Search series by title
     *
     * @param string $query
     * @return Collection
     */
    public function searchByTitle(string $query): Collection
    {
        return $this->model->whereHas('content', function($q) use ($query) {
            $q->where('title', 'like', "%{$query}%");
        })->get();
    }

    /**
     * Get series by category
     *
     * @param int $categoryId
     * @return Collection
     */
    public function getByCategory(int $categoryId): Collection
    {
        return $this->model->whereHas('content.categories', function($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        })->get();
    }

    /**
     * Get series by tag
     * 
     * @param int $tagId
     * @return Collection
     */
    public function getByTag(int $tagId): Collection
    {
        return $this->model->whereHas('content.tags', function($q) use ($tagId) {
            $q->where('tags.id', $tagId);
        })->get();
    }

    /**
     * Get series by actor
     *
     * @param int $actorId
     * @return Collection
     */
    public function getByActor(int $actorId): Collection
    {
        return $this->model->whereHas('actors', function($q) use ($actorId) {
            $q->where('actors.id', $actorId);
        })->get();
    }

    /**
     * Get episodes by series and season
     *
     * @param int $seriesId
     * @param int $seasonNumber
     * @return Collection
     */
    public function getEpisodesBySeason(int $seriesId, int $seasonNumber): Collection
    {
        $series = $this->findById($seriesId);
        
        if (!$series) {
            return collect();
        }
        
        return $series->episodes()
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
        return $this->model
            ->join('contents', 'series.content_id', '=', 'contents.id')
            ->orderBy('contents.views_count', 'desc')
            ->select('series.*')
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
        return $this->model
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
