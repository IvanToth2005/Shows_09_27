<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\SeriesController;
use App\Models\Film;
use App\Models\Series;

Route::get('/', function () {
    $filmCount = Film::count();
    $seriesCount = Series::count();
    return view('welcome', compact('filmCount','seriesCount'));
})->name('home');

Route::resource('films', FilmController::class)->parameters(['films' => 'film']);
Route::resource('series', SeriesController::class)->parameters(['series' => 'series']);
