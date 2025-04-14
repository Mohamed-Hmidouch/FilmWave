<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    /**
     * Get all categories
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get paginated categories
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator;

    /**
     * Find category by ID
     *
     * @param int $id
     * @return Category|null
     */
    public function findById(int $id): ?Category;

    /**
     * Find category by name
     *
     * @param string $name
     * @return Category|null
     */
    public function findByName(string $name): ?Category;

    /**
     * Create a new category
     *
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category;

    /**
     * Update category
     *
     * @param array $data
     * @param int $id
     * @return Category|null
     */
    public function update(array $data, int $id): ?Category;

    /**
     * Delete category
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get categories with their related content count
     *
     * @return Collection
     */
    public function getCategoriesWithContentCount(): Collection;
} 