<?php

namespace App\Http\Controllers;

use App\Models\Director;
use Illuminate\Http\Request;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = trim((string)$request->query('q', ''));

        $directors = Director::with([
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

        return view('directors.index', compact('directors','q'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('directors.create');
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

        Director::create($data);

        return redirect()->route('directors.index')->with('success', 'Rendező hozzáadva.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Director $director)
    {
            
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Director $director)
    {
        return view('directors.edit', compact('director'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Director $director)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|url|max:255',
        ]);

        $director->update($data);

        return redirect()->route('directors.index', $director)->with('success', 'Rendező frissítve.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Director $director)
    {
        $director->delete();

        return redirect()->route('directors.index')->with('success', 'Rendező törölve.');
    }
}
