<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TagRepository implements TagRepositoryInterface
{
    /**
     * Get all tags
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Tag::orderBy('name', 'asc')->get();
    }

    /**
     * Get paginated tags
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Tag::orderBy('name', 'asc')->paginate($perPage);
    }

    /**
     * Find tag by ID
     *
     * @param int $id
     * @return Tag|null
     */
    public function findById(int $id): ?Tag
    {
        return Tag::find($id);
    }

    /**
     * Find tag by name
     *
     * @param string $name
     * @return Tag|null
     */
    public function findByName(string $name): ?Tag
    {
        return Tag::where('name', $name)->first();
    }

    /**
     * Create a new tag
     *
     * @param array $data
     * @return Tag
     */
    public function create(array $data): Tag
    {
        return Tag::create([
            'name' => $data['name']
        ]);
    }

    /**
     * Update tag
     *
     * @param array $data
     * @param int $id
     * @return Tag|null
     */
    public function update(array $data, int $id): ?Tag
    {
        $tag = $this->findById($id);
        
        if (!$tag) {
            return null;
        }
        
        $tag->name = $data['name'];
        $tag->save();
        
        return $tag;
    }

    /**
     * Delete tag
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $tag = $this->findById($id);
        
        if (!$tag) {
            return false;
        }
        
        return $tag->delete();
    }

    /**
     * Get tags with their related content count
     *
     * @return Collection
     */
    public function getTagsWithContentCount(): Collection
    {
        return Tag::withCount('contents')->orderBy('name', 'asc')->get();
    }
} 