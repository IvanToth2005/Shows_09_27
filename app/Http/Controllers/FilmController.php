<?php

namespace App\Http\Controllers;

use App\Models\{Film, Type, Director};
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
    $q = trim((string)$request->query('q', ''));

    $query = Film::with(['director','type']);

    if ($typeParam !== 'all' && ctype_digit((string)$typeParam)) {
        $query->where('type_id', (int)$typeParam);
    }

    if ($q !== '') {
        $query->where(function($w) use ($q) {
            $w->where('title', 'like', "%{$q}%")
              ->orWhereHas('director', fn($d)=>$d->where('name','like',"%{$q}%"))
              ->orWhereHas('type',     fn($t)=>$t->where('name','like',"%{$q}%"));
        });
    }

    $films = $query->orderBy('title')->paginate(12)->withQueryString();

    return view('films.index', compact('films','types','typeParam','q'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::orderBy('name')->get();
        $directors = Director::orderBy('name')->get();
 
        return view('films.create', compact('types','directors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        {
            $data = $request->validate([
                'title'        => 'required|string|max:255',
                'director_id'  => 'required|exists:directors,id',
                'release_date' => 'nullable|date',
                'type_id'      => 'nullable|exists:types,id',
                'length'       => 'nullable|integer|min:1',
                'description'  => 'nullable|string',
            ]);
     
            Film::create($data);
     
            return redirect()->route('films.index')
                ->with('success','Film sikeresen hozzáadva!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        $film->load(['director','type','actors']); 
        return view('films.show', compact('film'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        $types     = Type::orderBy('name')->get();
        $directors = Director::orderBy('name')->get();

        return view('films.edit', compact('film', 'types', 'directors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Film $film)
    {
        $data = $request->validate([
            'title'        => ['required','string','max:255'],
            'director_id'  => ['required','exists:directors,id'],
            'type_id'      => ['required','exists:types,id'],
            'release_date' => ['nullable','date'],
            'length'       => ['nullable','integer','min:1'],
            'image'        => ['nullable','string','max:255'], 
            'description'  => ['nullable','string'],
        ]);

       
        if (array_key_exists('image', $data) && trim((string)$data['image']) === '') {
            $data['image'] = null;
        }

        $film->update($data);

        return redirect()
            ->route('films.show', $film)
            ->with('success', 'Film frissítve.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        $film->actors()->detach();
        $film->delete();
        return redirect()
            ->route('films.index')
            ->with('success', 'Film törölve: '.$film->title);
    }
}
