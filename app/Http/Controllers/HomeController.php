<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Series;

class HomeController extends Controller
{
    public function index()
    {
        // Opcionális: mutassuk a darabszámokat
        $filmCount = Film::count();
        $seriesCount = Series::count();

        return view('home', compact('filmCount', 'seriesCount'));
    }
}
