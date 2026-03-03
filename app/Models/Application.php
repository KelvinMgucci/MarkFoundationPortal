<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\JobListing;

class Application extends Model
{
    protected $fillable = [
        'job_id',
        'full_name',
        'email',
        'phone',
        'cover_letter',
        'cv_path',
        'status',
    ];

    public const STATUSES = ['new', 'reviewed', 'shortlisted', 'rejected'];

    public const STATUS_LABELS = [
        'new'         => 'New',
        'reviewed'    => 'Reviewed',
        'shortlisted' => 'Shortlisted',
        'rejected'    => 'Rejected',
    ];

    // ── Relationships ────────────────────────────────────────────────────────

    public function job(): BelongsTo
    {
        return $this->belongsTo(JobListing::class);
    }
}
