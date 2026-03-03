<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class GalleryItem extends Model
{
    protected $fillable = [
        'title', 'description', 'type', 'file_path',
        'video_url', 'thumbnail_path', 'sort_order', 'is_visible',
    ];

    protected $casts = ['is_visible' => 'boolean'];

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_visible', true);
    }

    public function isPhoto(): bool { return $this->type === 'photo'; }
    public function isVideo(): bool { return $this->type === 'video'; }

    public function embedUrl(): ?string
    {
        if (! $this->video_url) return null;
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $this->video_url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }
        if (preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $m)) {
            return 'https://player.vimeo.com/video/' . $m[1];
        }
        return $this->video_url;
    }
}
