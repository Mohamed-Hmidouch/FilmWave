<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SeriesService;
use Illuminate\Support\Str;
use App\Models\Series;

class HomeController extends Controller
{
    /**
     * @var SeriesService
     */
    private $seriesService;

    /**
     * HomeController constructor.
     *
     * @param SeriesService $seriesService
     */
    public function __construct(SeriesService $seriesService)
    {
        $this->seriesService = $seriesService;
    }

    public function welcome()
    {
        return view('welcome');
    }

    public function index()
    {
        try {
            // Récupérer les données des séries
            $series = $this->seriesService->getAllSeries();            
            // Pass the series data directly with the variable name expected by the view
            return view('user.homme', [
                'series' => $series
            ]);
        } catch (\Exception $e) {
            // Enregistrer l'erreur dans les logs
            \Log::error('Error in HomeController@index: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            
        }
    }

    public function movies()
    {
        try {
            $series = $this->seriesService->getAllSeries();
            return view('movies', [
                'featuredSeries' => $series
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in HomeController@movies: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return view('movies', ['error' => $e->getMessage()]);
        }
    }

    public function tvshows()
    {
        try {
            $series = $this->seriesService->getAllSeries();
            return view('tvshows', [
                'featuredSeries' => $series
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in HomeController@tvshows: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return view('tvshows', ['error' => $e->getMessage()]);
        }
    }

    public function newReleases()
    {
        try {
            $series = $this->seriesService->getAllSeries();
            return view('new-releases', [
                'featuredSeries' => $series
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in HomeController@newReleases: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return view('new-releases', ['error' => $e->getMessage()]);
        }
    }

    public function myList()
    {
        $user = Auth::user();
        return view('user.my-list', compact('user'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function settings()
    {
        $user = Auth::user();
        return view('user.settings', compact('user'));
    }

    public function featuredSeries()
    {
        $featuredSeries = $this->prepareFeaturedSeriesData();
        
        return view('featured-series', [
            'featuredSeries' => $featuredSeries,
        ]);
    }

}
