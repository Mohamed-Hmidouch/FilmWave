<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SeriesService;

class UserController extends Controller
{
    private $seriesService;

    public function __construct(SeriesService $seriesService)
    {
        $this->seriesService = $seriesService;
    }

    public function index(Request $request)
    {
        try {
            // Utiliser la pagination avec 10 éléments par page
            $series = $this->seriesService->getPaginatedSeries(10);
            return view('user.homme', [
                'series' => $series
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in UserController@index: ' . $e->getMessage());
            return view('user.homme')->with('error', $e->getMessage());
        }
    }
}
