<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model {
    protected $fillable = ['quote','author_name','author_location','sort_order','is_visible'];
    protected $casts = ['is_visible' => 'boolean'];
    public function scopeVisible($q) { return $q->where('is_visible', true); }
}
