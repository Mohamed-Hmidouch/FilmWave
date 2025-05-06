<?php

namespace App\Services;

use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class TagService
{
    private $tagRepository;
    
    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAllTags(): Collection
    {
        return $this->tagRepository->getAll();
    }

    public function getPaginatedTags(int $perPage = 10): LengthAwarePaginator
    {
        return $this->tagRepository->getPaginated($perPage);
    }

    public function findTagById(int $id): ?Tag
    {
        return $this->tagRepository->findById($id);
    }

    public function createTag(array $data): Tag
    {
        try {
            return $this->tagRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error creating tag: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateTag(int $id, array $data): ?Tag
    {
        try {
            return $this->tagRepository->update($data, $id);
        } catch (\Exception $e) {
            Log::error('Error updating tag: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteTag(int $id): bool
    {
        try {
            return $this->tagRepository->delete($id);
        } catch (\Exception $e) {
            Log::error('Error deleting tag: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getTagsWithContentCount(): Collection
    {
        return $this->tagRepository->getTagsWithContentCount();
    }
}