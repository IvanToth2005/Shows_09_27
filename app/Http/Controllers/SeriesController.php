<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;
use App\Models\Director;
use App\Models\Type;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $types = Type::orderBy('name')->get();
        $typeParam = $request->query('type','all');
        $q = trim((string)$request->query('q',''));

        $query = Series::with(['director','type']);

        if ($typeParam !== 'all' && ctype_digit((string)$typeParam)) {
            $query->where('type_id', (int)$typeParam);
        }

        if ($q !== '') {
            $query->where(function($w) use ($q) {
                $w->where('title','like',"%{$q}%")
                ->orWhereHas('director', fn($d)=>$d->where('name','like',"%{$q}%"))
                ->orWhereHas('type',     fn($t)=>$t->where('name','like',"%{$q}%"));
            });
        }

        $series = $query->orderBy('title')->paginate(12)->withQueryString();

        return view('series.index', compact('series','types','typeParam','q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types     = Type::orderBy('name')->get();
        $directors = Director::orderBy('name')->get();

        return view('series.create', compact('types','directors'));
    }


    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
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

        $series = Series::create($data);

        return redirect()
            ->route('series.index')      // ha már van show oldalad, cseréld: series.show, $series
            ->with('success', 'Sorozat létrehozva: '.$series->title);
    }
    /**
     * Display the specified resource.
     */
    public function show(Series $series)
    {
        $series->load(['type','director','actors']);
        return view('series.show', compact('series'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Series $series)
    {
        $types     = Type::orderBy('name')->get();
        $directors = Director::orderBy('name')->get();
        return view('series.edit', compact('series','types','directors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Series $series)
    {
        $data = $request->validate([
            'title'        => ['required','string','max:255'],
            'director_id'  => ['required','exists:directors,id'],
            'type_id'      => ['required','exists:types,id'],
            'release_date' => ['nullable','date'],
            'seasons'      => ['nullable','integer','min:1'],
            'length'       => ['nullable','integer','min:1'],
            'image'        => ['nullable','string','max:255'],
            'description'  => ['nullable','string'],
        ]);
        if (isset($data['image']) && trim((string)$data['image']) === '') $data['image'] = null;

        $series->update($data);

        return redirect()->route('series.show',$series)->with('success','Sorozat frissítve.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Series $series)
    {
        $series->actors()->detach();
        $series->delete();
        return redirect()->route('series.index')->with('success','Sorozat törölve.');
    }
}
