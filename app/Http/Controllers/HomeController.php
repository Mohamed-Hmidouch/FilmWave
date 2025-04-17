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

            // Add dd() here to debug
            dd([
                'series' => $series,
                'series_count' => is_array($series) || is_object($series) ? count($series) : 0,
                'series_type' => gettype($series)
            ]);
            
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
    
    /**
     * Prepare data for featured series section
     * 
     * @return array
     */
    private function prepareFeaturedSeriesData()
    {
        $series = Series::with([
            'content',
            'content.categories',
            'content.tags',
            'content.actors',
            'content.ratings',
            'seasons.episodes'
        ])->get();
        
        \Log::info('Series count: ' . $series->count());
        
        if ($series->isEmpty()) {
            \Log::warning('No series found in the database');
            return [];
        }
        
        return $series->map(function ($item) {
            \Log::info('Processing series: ' . $item->title);
            
            if (!$item->content) {
                \Log::warning('No content found for series: ' . $item->id);
                return null;
            }
            
            $season = $item->seasons->first();
            $episode = $season ? $season->episodes->first() : null;
            
            $categories = optional($item->content)->categories ? $item->content->categories->take(2)->pluck('name')->toArray() : [];
            $tags = optional($item->content)->tags ? $item->content->tags->pluck('name')->toArray() : [];
            
            $rating = optional($item->content)->ratings ? 
                $item->content->ratings->avg('rating_value') ?? number_format(rand(35, 50) / 10, 1) : 
                number_format(rand(35, 50) / 10, 1);
            
            return [
                'id' => $item->id,
                'title' => $item->title,
                'coverImage' => optional($item->content)->cover_image ?? '/images/default-cover.jpg',
                'seasonNumber' => $season ? $season->season_number : 1,
                'episodeNumber' => $episode ? $episode->episode_number : 1,
                'releaseYear' => optional($item->content)->release_year ?? date('Y'),
                'duration' => $episode ? $episode->duration : 45,
                'rating' => $rating,
                'categories' => $categories,
                'tags' => $tags,
                'description' => optional($item->content)->description ?? '',
                'actors' => optional($item->content)->actors ? $item->content->actors->pluck('name')->toArray() : [],
                'total_episodes' => $item->total_episodes ?? 0,
                'views_count' => $item->views_count ?? 0,
            ];
        })->filter()->values()->toArray();
    }
    
    /**
     * Prepare data for popular series section
     * 
     * @return array
     */
    private function preparePopularSeriesData()
    {
        $series = Series::with(['content', 'content.categories', 'seasons.episodes'])
            ->orderBy('views_count', 'desc')
            ->take(10)
            ->get();
        
        return $series->map(function ($item) {
            // Get the first season and episode for the series
            $season = $item->seasons->first();
            $episode = $season ? $season->episodes->first() : null;
            
            // Get the first two categories
            $categories = $item->content->categories->take(2)->pluck('name')->toArray();
            
            // Calculate rating or use a random one if none exists
            $rating = $item->content->ratings->avg('rating_value') ?? number_format(rand(35, 50) / 10, 1);
            
            return [
                'id' => $item->id,
                'title' => $item->title,
                'coverImage' => $item->content->cover_image ?? '/images/default-cover.jpg',
                'seasonNumber' => $season ? $season->season_number : 1,
                'episodeNumber' => $episode ? $episode->episode_number : 1,
                'releaseYear' => $item->content->release_year ?? date('Y'),
                'duration' => $episode ? $episode->duration : 45,
                'rating' => $rating,
                'categories' => $categories,
            ];
        })->toArray();
    }
}
