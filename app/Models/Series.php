<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Series extends Model
{
    use HasFactory;

    protected $table = 'series';

    protected $fillable = [
        'title',
        'director_id',
        'release_date',
        'description',
        'image',
        'type_id',
        'length', 
    ];

    protected $casts = [
        'release_date' => 'date',
        'length'       => 'integer',
    ];

    public function director(): BelongsTo
    {
        return $this->belongsTo(Director::class);
    }

    public function tyoe(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'series_actor', 'series_id', 'actor_id')
            ->withPivot('is_lead')
            ->withTimestamps();
    }
    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return 'https://placehold.co/800x1200?text='.urlencode($this->title);
        }
        return preg_match('#^https?://#', $this->image) ? $this->image : asset($this->image);
    }
}
