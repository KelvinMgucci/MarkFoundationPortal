<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'title', 'description', 'location', 'start_date',
        'end_date', 'cover_image_path', 'rsvp_link', 'is_published',
    ];

    protected $casts = [
        'start_date'   => 'datetime',
        'end_date'     => 'datetime',
        'is_published' => 'boolean',
    ];

    public function media(): HasMany
    {
        return $this->hasMany(EventMedia::class)->orderBy('sort_order');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(EventMedia::class)->where('type', 'photo')->orderBy('sort_order');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(EventMedia::class)->where('type', 'video')->orderBy('sort_order');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function isUpcoming(): bool
    {
        return $this->start_date->isFuture();
    }

    public function isPast(): bool
    {
        return $this->start_date->isPast();
    }
}
