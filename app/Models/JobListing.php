<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class JobListing extends Model
{
    protected $table = 'job_listings';

    protected $fillable = [
        'title',
        'location',
        'type',
        'description',
        'requirements',
        'responsibilities',
        'status',
    ];

    public const TYPES = [
        'Full-Time',
        'Part-Time',
        'Contract',
        'Remote',
        'Internship',
    ];

    // ── Relationships ────────────────────────────────────────────────────────

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'job_id');
    }

    // ── Scopes ───────────────────────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function excerpt(int $limit = 160): string
    {
        return \Str::limit(strip_tags($this->description), $limit);
    }
}
