<?php

namespace App\Repositories\Interfaces;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TagRepositoryInterface
{
    /**
     * Get all tags
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get paginated tags
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator;

    /**
     * Find tag by ID
     *
     * @param int $id
     * @return Tag|null
     */
    public function findById(int $id): ?Tag;

    /**
     * Find tag by name
     *
     * @param string $name
     * @return Tag|null
     */
    public function findByName(string $name): ?Tag;

    /**
     * Create a new tag
     *
     * @param array $data
     * @return Tag
     */
    public function create(array $data): Tag;

    /**
     * Update tag
     *
     * @param array $data
     * @param int $id
     * @return Tag|null
     */
    public function update(array $data, int $id): ?Tag;

    /**
     * Delete tag
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get tags with their related content count
     *
     * @return Collection
     */
    public function getTagsWithContentCount(): Collection;
} 