<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Actor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'film_actor', 'actor_id', 'film_id')
            ->withPivot('is_lead')
            ->withTimestamps();
    }

    public function series()
    {
        return $this->belongsToMany(Series::class, 'series_actor', 'actor_id', 'series_id')
            ->withPivot('is_lead')
            ->withTimestamps();
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return 'https://placehold.co/300x300?text='.urlencode($this->name);
        }
        return preg_match('#^https?://#', $this->image) ? $this->image : asset($this->image);
    }
}
