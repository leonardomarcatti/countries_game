<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class MainController extends Controller
{
    private array $app_data;

    public function __construct()
    {
        // Load countries and capitals

        $this->app_data = config('app_data');
    }

    public function showData(): JsonResponse
    {
        return \response()->json($this->app_data);
    }

    public function home() : View
    {
        return \view('welcome');
    }
}
