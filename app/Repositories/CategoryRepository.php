<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Get all categories
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Category::orderBy('name', 'asc')->get();
    }

    /**
     * Get paginated categories
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Category::orderBy('name', 'asc')->paginate($perPage);
    }

    /**
     * Find category by ID
     *
     * @param int $id
     * @return Category|null
     */
    public function findById(int $id): ?Category
    {
        return Category::find($id);
    }

    /**
     * Find category by name
     *
     * @param string $name
     * @return Category|null
     */
    public function findByName(string $name): ?Category
    {
        return Category::where('name', $name)->first();
    }

    /**
     * Create a new category
     *
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category
    {
        return Category::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null
        ]);
    }

    /**
     * Update category
     *
     * @param array $data
     * @param int $id
     * @return Category|null
     */
    public function update(array $data, int $id): ?Category
    {
        $category = $this->findById($id);
        
        if (!$category) {
            return null;
        }
        
        $category->name = $data['name'];
        $category->slug = Str::slug($data['name']);
        
        if (isset($data['description'])) {
            $category->description = $data['description'];
        }
        
        $category->save();
        
        return $category;
    }

    /**
     * Delete category
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $category = $this->findById($id);
        
        if (!$category) {
            return false;
        }
        
        return $category->delete();
    }

    /**
     * Get categories with their related content count
     *
     * @return Collection
     */
    public function getCategoriesWithContentCount(): Collection
    {
        return Category::withCount('contents')->orderBy('name', 'asc')->get();
    }
} 