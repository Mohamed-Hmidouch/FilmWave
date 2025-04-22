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
        try {
            // Récupérer les séries récentes avec leurs contenus et épisodes associés
            $recentSeries = $this->seriesService->getRecentSeries(10);
            
            // Pour chaque série, charger les relations nécessaires si ce n'est pas déjà fait
            $recentSeries->load(['content', 'content.categories', 'content.tags', 'episodes']);
            
            return view('admin.Series', compact('recentSeries'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors du chargement des séries: ' . $e->getMessage());
        }
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
        try {
            // Récupérer la série avec toutes ses relations
            $series = $this->seriesService->findSeriesById(
                $id, 
                ['content', 'content.categories', 'content.tags', 'seasons', 'episodes', 'actors']
            );
            
            if (!$series) {
                return redirect()->route('admin.series.index')
                    ->with('error', 'Série non trouvée.');
            }
            
            // Récupérer les catégories sélectionnées
            $selectedCategory = $series->content->categories->first();
            
            // Récupérer les tags sélectionnés
            $selectedTags = $series->content->tags->pluck('name')->toArray();
            
            // Récupérer les acteurs sélectionnés
            $selectedActors = $series->actors->pluck('name')->toArray();
            
            // Récupérer toutes les séries disponibles pour l'affectation d'épisodes
            $allSeries = $this->seriesService->getAllSeries();
            
            return view('admin.series.edit', compact('series', 'selectedCategory', 'selectedTags', 'selectedActors', 'allSeries'));
        } catch (\Exception $e) {
            return redirect()->route('admin.series.index')
                ->with('error', 'Erreur lors du chargement de la série: ' . $e->getMessage());
        }
    }

    /**
     * Mettre à jour une série existante
     * 
     * @param Request $request
     * @param string $id
     * @param SeriesValidator $validator
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id, SeriesValidator $validator)
    {
        try {
            // Vérifier si la série existe
            $series = $this->seriesService->findSeriesById($id);
            
            if (!$series) {
                return redirect()->route('admin.series.index')
                    ->with('error', 'Série non trouvée.');
            }
            
            // Préparation des données avec notre validateur injecté
            $data = $validator->getSeriesData();
            
            // Mise à jour de la série avec toutes ses relations
            $updatedSeries = $this->seriesService->updateSeries($id, $data);
            
            if ($updatedSeries) {
                return redirect()->route('admin.series.index')
                    ->with('success', 'Série mise à jour avec succès.');
            } else {
                return redirect()->back()
                    ->with('error', 'Erreur lors de la mise à jour de la série.')
                    ->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour de la série: ' . $e->getMessage())
                ->withInput();
        }
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
