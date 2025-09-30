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
        return view('actors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|url|max:255',
        ]);

        Actor::create($data);

        return redirect()->route('actors.index')->with('success', 'Színész hozzáadva.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Actor $actor)
    {
           
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Actor $actor)
    {
        return view('actors.edit', compact('actor'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Actor $actor)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|url|max:255',
        ]);

        $actor->update($data);

        return redirect()->route('actors.index', $actor)->with('success', 'Színész frissítve.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Actor $actor)
    {
        $actor->delete();

        return redirect()->route('actors.index')->with('success', 'Színész törölve.');
    }
}
