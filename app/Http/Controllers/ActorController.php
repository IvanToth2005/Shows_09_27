<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = trim((string)$request->query('q', ''));

        $actors = Actor::with([
                'films.type','films.director',
                'series.type','series.director',
            ])
            ->when($q !== '', function ($query) use ($q) {
                $query->where('name','like',"%{$q}%")
                    ->orWhereHas('films', fn($f)=>$f->where('title','like',"%{$q}%"))
                    ->orWhereHas('series', fn($s)=>$s->where('title','like',"%{$q}%"));
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('actors.index', compact('actors','q'));
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
    public function show(Actor $actor)
    {
            $actor->load(['films.type','films.director','series.type','series.director']);
            return view('actors.show', compact('actor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Actor $actor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Actor $actor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Actor $actor)
    {
        //
    }
}
