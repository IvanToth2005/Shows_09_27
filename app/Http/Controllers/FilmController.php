<?php

namespace App\Http\Controllers;

use App\Models\{Film, Type};
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function index(Request $request)
    {
        $types = Type::orderBy('name')->get();

        $typeParam = $request->query('type', 'all');
        $query = Film::with(['director','type']);

        if ($typeParam !== 'all' && ctype_digit((string)$typeParam)) {
            $query->where('type_id', (int)$typeParam);
        }

        $films = $query->orderBy('title')->paginate(12)->withQueryString();

        return view('films.index', compact('films','types','typeParam'));
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
    public function show(Film $film)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Film $film)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        //
    }
}
