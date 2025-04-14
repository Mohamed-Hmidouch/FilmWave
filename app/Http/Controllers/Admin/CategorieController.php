<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\CategoryService;
use App\Requests\Admin\CategoryValidator;
use Illuminate\Http\Request;

class CategorieController extends BaseController
{
    /**
     * @var CategoryService
     */
    protected $categoryService;
    
    /**
     * Constructeur du contrôleur
     * 
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    
    /**
     * Afficher la liste des catégories
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $categories = $this->categoryService->getPaginatedCategories($perPage);
        
        return view('admin.categories', compact('categories'));
    }

    /**
     * Afficher le formulaire de création d'une catégorie
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Enregistrer une nouvelle catégorie
     * 
     * @param CategoryValidator $validator
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryValidator $validator)
    {
        if (!$validator->isStatus()) {
            return response()->json(['error' => $validator->getErrors()], 422);
        }

        try {
            $category = $this->categoryService->createCategory($validator->getCategoryData());
            return response()->json([
                'success' => true, 
                'message' => 'Catégorie créée avec succès',
                'category' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la création de la catégorie: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Traiter l'ajout de catégories en lot (batch)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeBatch(Request $request)
    {
        $request->validate([
            'category_names' => 'required|string'
        ]);

        $categoryNames = array_map('trim', explode(',', $request->category_names));
        $categoryNames = array_filter($categoryNames, function($name) {
            return !empty($name);
        });

        if (empty($categoryNames)) {
            return response()->json(['error' => 'Aucune catégorie valide fournie'], 422);
        }

        $result = $this->categoryService->createMultipleCategories($categoryNames);
        
        return response()->json([
            'success' => true,
            'message' => count($result['categories']) . ' catégorie(s) créée(s) avec succès',
            'categories' => $result['categories'],
            'errors' => $result['errors']
        ]);
    }

    /**
     * Afficher les détails d'une catégorie
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $category = $this->categoryService->findCategoryById($id);
        
        if (!$category) {
            abort(404, 'Catégorie non trouvée');
        }
        
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Afficher le formulaire d'édition d'une catégorie
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $category = $this->categoryService->findCategoryById($id);
        
        if (!$category) {
            abort(404, 'Catégorie non trouvée');
        }
        
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Mettre à jour une catégorie existante
     * 
     * @param CategoryValidator $validator
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryValidator $validator, $id)
    {
        if (!$validator->isStatus()) {
            return response()->json(['error' => $validator->getErrors()], 422);
        }

        try {
            $category = $this->categoryService->updateCategory($id, $validator->getCategoryData());
            
            if (!$category) {
                return response()->json(['error' => 'Catégorie non trouvée'], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Catégorie mise à jour avec succès',
                'category' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la mise à jour de la catégorie: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer une catégorie
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $result = $this->categoryService->deleteCategory($id);
            
            if (!$result) {
                return response()->json(['error' => 'Catégorie non trouvée'], 404);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Catégorie supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la suppression de la catégorie: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer plusieurs catégories en lot
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyBatch(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:categories,id'
        ]);

        $result = $this->categoryService->deleteMultipleCategories($request->ids);
        
        return response()->json([
            'success' => true,
            'message' => $result['deleted'] . ' catégorie(s) supprimée(s) avec succès',
            'errors' => $result['errors']
        ]);
    }

    /**
     * Importer des catégories depuis un fichier CSV
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request)
    {
        $request->validate([
            'categories_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('categories_file');
        $categoryNames = [];

        if (($handle = fopen($file->getPathname(), 'r')) !== false) {
            // Lire l'en-tête
            $header = fgetcsv($handle);
            $nameColumnIndex = array_search('name', $header);
            
            if ($nameColumnIndex === false) {
                fclose($handle);
                return response()->json([
                    'error' => 'Le fichier CSV doit contenir une colonne "name"'
                ], 422);
            }

            // Lire les données
            while (($data = fgetcsv($handle)) !== false) {
                if (isset($data[$nameColumnIndex]) && !empty($data[$nameColumnIndex])) {
                    $categoryNames[] = $data[$nameColumnIndex];
                }
            }
            fclose($handle);
        }

        $result = $this->categoryService->createMultipleCategories($categoryNames);
        
        return response()->json([
            'success' => true,
            'message' => count($result['categories']) . ' catégorie(s) importée(s) avec succès',
            'errors' => $result['errors']
        ]);
    }

    /**
     * Exporter des catégories au format CSV
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        $categories = collect([]);
        
        if ($request->has('ids')) {
            // Exporter uniquement les catégories sélectionnées
            $categoryIds = explode(',', $request->ids);
            foreach ($categoryIds as $id) {
                $category = $this->categoryService->findCategoryById($id);
                if ($category) {
                    $categories->push($category);
                }
            }
        } else {
            // Exporter toutes les catégories
            $categories = $this->categoryService->getAllCategories();
        }

        $filename = 'categories_export_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, ['id', 'name', 'slug', 'description', 'created_at', 'updated_at']);

        foreach ($categories as $category) {
            fputcsv($handle, [
                $category->id,
                $category->name,
                $category->slug,
                $category->description,
                $category->created_at,
                $category->updated_at
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, $headers);
    }
} 