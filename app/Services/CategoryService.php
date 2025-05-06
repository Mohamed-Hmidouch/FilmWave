<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    private $categoryRepository;
    
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->getAll();
    }

    public function getPaginatedCategories(int $perPage = 10): LengthAwarePaginator
    {
        return $this->categoryRepository->getPaginated($perPage);
    }

    public function findCategoryById(int $id): ?Category
    {
        return $this->categoryRepository->findById($id);
    }

    public function findCategoryByName(string $name): ?Category
    {
        return $this->categoryRepository->findByName($name);
    }

    public function createCategory(array $data): Category
    {
        try {
            return $this->categoryRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateCategory(int $id, array $data): ?Category
    {
        try {
            return $this->categoryRepository->update($data, $id);
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteCategory(int $id): bool
    {
        try {
            return $this->categoryRepository->delete($id);
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createMultipleCategories(array $namesList): array
    {
        $createdCategories = [];
        $errors = [];
        
        foreach ($namesList as $name) {
            try {
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

    public function getCategoriesWithContentCount(): Collection
    {
        return $this->categoryRepository->getCategoriesWithContentCount();
    }
}