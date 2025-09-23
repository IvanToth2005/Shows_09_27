<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Film, Series, Actor};
class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = trim((string)$request->query('q',''));
        if ($q === '') {
            return view('search.index', [
                'q'      => $q,
                'films'  => collect(),
                'series' => collect(),
                'actors' => collect(),
            ]);
        }

        // FILMEK + SOROZATOK keresése (cím + rendező + típus)
        $films = Film::with(['type','director','actors'])
            ->where(function($w) use ($q) {
                $w->where('title','like',"%{$q}%")
                  ->orWhereHas('director', fn($d)=>$d->where('name','like',"%{$q}%"))
                  ->orWhereHas('type',     fn($t)=>$t->where('name','like',"%{$q}%"));
            })
            ->orderBy('title')
            ->get();

        $series = Series::with(['type','director','actors'])
            ->where(function($w) use ($q) {
                $w->where('title','like',"%{$q}%")
                  ->orWhereHas('director', fn($d)=>$d->where('name','like',"%{$q}%"))
                  ->orWhereHas('type',     fn($t)=>$t->where('name','like',"%{$q}%"));
            })
            ->orderBy('title')
            ->get();


        $filmTitleHit   = Film::where('title','like',"%{$q}%")->exists();
        $seriesTitleHit = Series::where('title','like',"%{$q}%")->exists();
        $suppressActorMatchesFromTitles = $filmTitleHit || $seriesTitleHit;


        if ($suppressActorMatchesFromTitles) {
            $actors = Actor::with(['films.type','films.director'])
                ->where('name','like',"%{$q}%")
                ->orderBy('name')
                ->get();
        } else {

            $actors = Actor::with(['films.type','films.director'])
                ->where('name','like',"%{$q}%")
                ->orWhereHas('films', function($f) use ($q) {
                    $f->where('title','like',"%{$q}%")
                      ->orWhereHas('director', fn($d)=>$d->where('name','like',"%{$q}%"))
                      ->orWhereHas('type',     fn($t)=>$t->where('name','like',"%{$q}%"));
                })
                ->orderBy('name')
                ->get();
        }

        return view('search.index', compact('q','films','series','actors'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
