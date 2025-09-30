<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Director, Type, Actor, Film, Series};

class DemoMediaSeeder extends Seeder
{
    public function run(): void
    {

        $scifi  = Type::firstOrCreate(['name' => 'Sci-Fi']);
        $drama  = Type::firstOrCreate(['name' => 'Dráma']);
        $action = Type::firstOrCreate(['name' => 'Akció']);
        $comedy = Type::firstOrCreate(['name' => 'Vígjáték']);
        $crime  = Type::firstOrCreate(['name' => 'Bűnügyi']);

        $nolan      = Director::firstOrCreate(['name' => 'Christopher Nolan']);
        $villeneuve = Director::firstOrCreate(['name' => 'Denis Villeneuve']);
        $chazelle   = Director::firstOrCreate(['name' => 'Damien Chazelle']);
        $gerwig     = Director::firstOrCreate(['name' => 'Greta Gerwig']);
        $gilligan   = Director::firstOrCreate(['name' => 'Vince Gilligan']);
        $renck      = Director::firstOrCreate(['name' => 'Johan Renck']);
        $favreau    = Director::firstOrCreate(['name' => 'Jon Favreau']);
        $duffer     = Director::firstOrCreate(['name' => 'Duffer Brothers']);


        $leo   = Actor::firstOrCreate(['name' => 'Leonardo DiCaprio']);
        $anne  = Actor::firstOrCreate(['name' => 'Anne Hathaway']);
        $margot= Actor::firstOrCreate(['name' => 'Margot Robbie']);
        $ryan  = Actor::firstOrCreate(['name' => 'Ryan Gosling']);
        $bryan = Actor::firstOrCreate(['name' => 'Bryan Cranston']);
        $aaron = Actor::firstOrCreate(['name' => 'Aaron Paul']);


        $inception = Film::firstOrCreate([
            'title' => 'Eredet',
            'director_id' => $nolan->id,
            'type_id' => $scifi->id,
            'release_date' => '2010-07-16',
            'length' => 148,
        ], ['description' => 'Álmok a főszerepben.']);

        $interstellar = Film::firstOrCreate([
            'title' => 'Csillagok között',
            'director_id' => $nolan->id,                 
            'type_id' => $scifi->id,
            'release_date' => '2014-11-07',
            'length' => 169,
        ]);

        $dune = Film::firstOrCreate([
            'title' => 'Dűne',
            'director_id' => $villeneuve->id,
            'type_id' => $scifi->id,
            'release_date' => '2021-10-22',
            'length' => 155,
        ]);

        $lala = Film::firstOrCreate([
            'title' => 'Kaliforniai álom',
            'director_id' => $chazelle->id,
            'type_id' => $drama->id,
            'release_date' => '2016-12-09',
            'length' => 128,
        ]);

        $barbie = Film::firstOrCreate([
            'title' => 'Barbie',
            'director_id' => $gerwig->id,
            'type_id' => $comedy->id,
            'release_date' => '2023-07-21',
            'length' => 114,
        ]);

        $barbie->update(['image' => 'img/barbie.jpg']);
        $interstellar->update(['image' => 'img/interstellar.jpg']);
        $dune->update(['image' => 'img/dune.jpg']);
        $inception->update(['image' => 'img/eredet.jpg']);
        $lala->update(['image' => 'img/alom.jpg']);


        $inception->actors()->syncWithoutDetaching([$leo->id => ['is_lead' => true]]);
        $interstellar->actors()->syncWithoutDetaching([$anne->id => ['is_lead' => true]]);
        $lala->actors()->syncWithoutDetaching([$ryan->id => ['is_lead' => true]]);
        $barbie->actors()->syncWithoutDetaching([$margot->id => ['is_lead' => true]]);


        $breakingbad = Series::firstOrCreate([
            'title' => 'Breaking Bad',
            'director_id' => $gilligan->id,
            'type_id' => $crime->id,
            'release_date' => '2008-01-20',
            'length' => 47,
        ]);

        $csernobil = Series::firstOrCreate([
            'title' => 'Csernobil',
            'director_id' => $renck->id,
            'type_id' => $drama->id,
            'release_date' => '2019-05-06',
            'length' => 60,
        ]);

        $mandalorian = Series::firstOrCreate([
            'title' => 'The Mandalorian',
            'director_id' => $favreau->id,
            'type_id' => $action->id,
            'release_date' => '2019-11-12',
            'length' => 40,
        ]);

        $strangerthings = Series::firstOrCreate([
            'title' => 'Stranger Things',
            'director_id' => $duffer->id,
            'type_id' => $drama->id,
            'release_date' => '2016-07-15',
            'length' => 50,
        ]);

        $westworld = Series::firstOrCreate([
            'title' => 'Westworld',
            'director_id' => $nolan->id, 
            'type_id' => $scifi->id,
            'release_date' => '2016-10-02',
            'length' => 60,
        ]);

        $breakingbad->update(['image' => 'img/breakingbad.jpg']);
        $csernobil->update(['image' => 'img/csernobil.jpg']);
        $mandalorian->update(['image' => 'img/mandalorian.jpg']);
        $strangerthings->update(['image' => 'img/strangerthings.jpg']);
        $westworld->update(['image' => 'img/westworld.jpg']);

        
        $bb = Series::where('title','Breaking Bad')->first();
        if ($bb) $bb->actors()->syncWithoutDetaching([$bryan->id => ['is_lead' => true], $aaron->id => ['is_lead' => true]]);
    }
}
