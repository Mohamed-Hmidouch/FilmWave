<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;
    
    /**
     * CategoryService constructor.
     *
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get all categories
     *
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->getAll();
    }

    /**
     * Get paginated categories
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedCategories(int $perPage = 10): LengthAwarePaginator
    {
        return $this->categoryRepository->getPaginated($perPage);
    }

    /**
     * Find category by ID
     *
     * @param int $id
     * @return Category|null
     */
    public function findCategoryById(int $id): ?Category
    {
        return $this->categoryRepository->findById($id);
    }

    /**
     * Find category by name
     *
     * @param string $name
     * @return Category|null
     */
    public function findCategoryByName(string $name): ?Category
    {
        return $this->categoryRepository->findByName($name);
    }

    /**
     * Create a new category
     *
     * @param array $data
     * @return Category
     */
    public function createCategory(array $data): Category
    {
        try {
            return $this->categoryRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update category
     *
     * @param int $id
     * @param array $data
     * @return Category|null
     */
    public function updateCategory(int $id, array $data): ?Category
    {
        try {
            return $this->categoryRepository->update($data, $id);
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete category
     *
     * @param int $id
     * @return bool
     */
    public function deleteCategory(int $id): bool
    {
        try {
            return $this->categoryRepository->delete($id);
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create multiple categories
     *
     * @param array $namesList
     * @return array
     */
    public function createMultipleCategories(array $namesList): array
    {
        $createdCategories = [];
        $errors = [];
        
        foreach ($namesList as $name) {
            try {
                // Vérifier si la catégorie existe déjà
                $exists = $this->findCategoryByName($name);
                if ($exists) {
                    $errors[] = "La catégorie '$name' existe déjà";
                    continue;
                }
                
                $category = $this->createCategory([
                    'name' => $name,
                    'description' => "Catégorie : $name"
                ]);
                
                $createdCategories[] = $category;
            } catch (\Exception $e) {
                $errors[] = "Erreur lors de la création de la catégorie '$name': " . $e->getMessage();
                Log::error("Error creating category '$name': " . $e->getMessage());
            }
        }
        
        return [
            'categories' => $createdCategories,
            'errors' => $errors
        ];
    }

    /**
     * Delete multiple categories
     *
     * @param array $ids
     * @return array
     */
    public function deleteMultipleCategories(array $ids): array
    {
        $deleted = 0;
        $errors = [];
        
        foreach ($ids as $id) {
            try {
                $result = $this->deleteCategory($id);
                if ($result) {
                    $deleted++;
                }
            } catch (\Exception $e) {
                $errors[] = "Erreur lors de la suppression de la catégorie ID $id: " . $e->getMessage();
                Log::error("Error deleting category ID $id: " . $e->getMessage());
            }
        }
        
        return [
            'deleted' => $deleted,
            'errors' => $errors
        ];
    }

    /**
     * Get categories with their content usage count
     *
     * @return Collection
     */
    public function getCategoriesWithContentCount(): Collection
    {
        return $this->categoryRepository->getCategoriesWithContentCount();
    }
} 