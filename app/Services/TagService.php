<?php

namespace App\Services;

use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class TagService
{
    /**
     * @var TagRepositoryInterface
     */
    private $tagRepository;
    
    /**
     * TagService constructor.
     *
     * @param TagRepositoryInterface $tagRepository
     */
    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * Get all tags
     *
     * @return Collection
     */
    public function getAllTags(): Collection
    {
        return $this->tagRepository->getAll();
    }

    /**
     * Get paginated tags
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedTags(int $perPage = 10): LengthAwarePaginator
    {
        return $this->tagRepository->getPaginated($perPage);
    }

    /**
     * Find tag by ID
     *
     * @param int $id
     * @return Tag|null
     */
    public function findTagById(int $id): ?Tag
    {
        return $this->tagRepository->findById($id);
    }

    /**
     * Create a new tag
     *
     * @param array $data
     * @return Tag
     */
    public function createTag(array $data): Tag
    {
        try {
            return $this->tagRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error creating tag: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update tag
     *
     * @param int $id
     * @param array $data
     * @return Tag|null
     */
    public function updateTag(int $id, array $data): ?Tag
    {
        try {
            return $this->tagRepository->update($data, $id);
        } catch (\Exception $e) {
            Log::error('Error updating tag: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete tag
     *
     * @param int $id
     * @return bool
     */
    public function deleteTag(int $id): bool
    {
        try {
            return $this->tagRepository->delete($id);
        } catch (\Exception $e) {
            Log::error('Error deleting tag: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get tags with their content usage count
     *
     * @return Collection
     */
    public function getTagsWithContentCount(): Collection
    {
        return $this->tagRepository->getTagsWithContentCount();
    }
} 