<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\TagService;
use App\Requests\Admin\TagValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends BaseController
{
    /**
     * @var TagService
     */
    protected $tagService;
    
    /**
     * Constructeur du contrôleur
     * 
     * @param TagService $tagService
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }
    
    /**
     * Afficher la liste des tags
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $tags = $this->tagService->getPaginatedTags($perPage);
        
        return view('admin.tags', compact('tags'));
    }

    /**
     * Traiter l'ajout de tags en lot (batch)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeBatch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tag_names' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $tagNames = array_map('trim', explode(',', $request->tag_names));
        $tagNames = array_filter($tagNames, function($name) {
            return !empty($name);
        });

        if (empty($tagNames)) {
            return response()->json(['error' => 'Aucun tag valide fourni'], 422);
        }

        $createdTags = [];
        $errors = [];

        foreach ($tagNames as $name) {
            try {
                $tag = $this->tagService->createTag(['name' => $name]);
                $createdTags[] = $tag;
            } catch (\Exception $e) {
                $errors[] = "Erreur lors de la création du tag '$name': " . $e->getMessage();
            }
        }

        return response()->json([
            'success' => true,
            'message' => count($createdTags) . ' tag(s) créé(s) avec succès',
            'tags' => $createdTags,
            'errors' => $errors
        ]);
    }

    /**
     * Mise à jour d'un tag existant
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:tags,id',
            'name' => 'required|string|max:50|unique:tags,name,' . $request->id
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            $tag = $this->tagService->updateTag($request->id, ['name' => $request->name]);
            return response()->json([
                'success' => true,
                'message' => 'Tag mis à jour avec succès',
                'tag' => $tag
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la mise à jour du tag: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un tag
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $result = $this->tagService->deleteTag($id);
            
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tag supprimé avec succès'
                ]);
            } else {
                return response()->json([
                    'error' => 'Tag non trouvé'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la suppression du tag: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer plusieurs tags en lot
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyBatch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:tags,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $deleted = 0;
        $errors = [];

        foreach ($request->ids as $id) {
            try {
                $result = $this->tagService->deleteTag($id);
                if ($result) {
                    $deleted++;
                }
            } catch (\Exception $e) {
                $errors[] = "Erreur lors de la suppression du tag ID $id: " . $e->getMessage();
            }
        }

        return response()->json([
            'success' => true,
            'message' => "$deleted tag(s) supprimé(s) avec succès",
            'errors' => $errors
        ]);
    }

    /**
     * Exporter des tags au format CSV
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        $tags = collect([]);
        
        if ($request->has('ids')) {
            // Exporter uniquement les tags sélectionnés
            $tagIds = explode(',', $request->ids);
            foreach ($tagIds as $id) {
                $tag = $this->tagService->findTagById($id);
                if ($tag) {
                    $tags->push($tag);
                }
            }
        } else {
            // Exporter tous les tags
            $tags = $this->tagService->getAllTags();
        }

        $filename = 'tags_export_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, ['id', 'name', 'created_at', 'updated_at']);

        foreach ($tags as $tag) {
            fputcsv($handle, [
                $tag->id,
                $tag->name,
                $tag->created_at,
                $tag->updated_at
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, $headers);
    }

    /**
     * Importer des tags depuis un fichier CSV
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tags_file' => 'required|file|mimes:csv,txt'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $file = $request->file('tags_file');
        $imported = 0;
        $errors = [];

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
                    try {
                        $this->tagService->createTag(['name' => $data[$nameColumnIndex]]);
                        $imported++;
                    } catch (\Exception $e) {
                        $errors[] = "Erreur lors de l'import du tag '{$data[$nameColumnIndex]}': " . $e->getMessage();
                    }
                }
            }
            fclose($handle);
        }

        return response()->json([
            'success' => true,
            'message' => "$imported tag(s) importé(s) avec succès",
            'errors' => $errors
        ]);
    }
}