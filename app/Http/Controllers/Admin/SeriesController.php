<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\SeriesService;
use App\Requests\Admin\SeriesValidator;
use Illuminate\Http\Request;

class SeriesController extends BaseController
{
    /**
     * @var SeriesService
     */
    protected $seriesService;
    
    /**
     * Constructeur du contrôleur
     * 
     * @param SeriesService $seriesService
     */
    public function __construct(SeriesService $seriesService){
        $this->seriesService = $seriesService;
    }
    
    /**
     * Afficher la liste des séries
     */
    public function index()
    {
        return view('admin.Series');
    }

    /**
     * Afficher le formulaire de création d'une série
     */
    public function create()
    {
        //
    }

    /**
     * Enregistrer une nouvelle série
     * 
     * @param Request $request
     * @param SeriesValidator $validator
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, SeriesValidator $validator)
    {
        try {
            // Préparation des données avec notre validateur injecté
            $data = $validator->getSeriesData();
            
            // Création de la série avec toutes ses relations
            $this->seriesService->createSeries($data);

            return redirect()->route('admin.series.index')
                ->with('success', 'Série créée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de la série: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Afficher une série spécifique
     * 
     * @param string $id
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Afficher le formulaire d'édition d'une série
     * 
     * @param string $id
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Mettre à jour une série existante
     * 
     * @param Request $request
     * @param string $id
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Supprimer une série
     * 
     * @param string $id
     */
    public function destroy(string $id)
    {
        //
    }
}
