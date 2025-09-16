<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Director extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function films(): HasMany
    {
        return $this->hasMany(Film::class);
    }

    public function series(): HasMany
    {
        return $this->hasMany(Series::class);
    }
}
