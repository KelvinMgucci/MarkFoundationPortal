<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model {
    protected $fillable = ['label','value','suffix','icon','sort_order','is_visible'];
    protected $casts = ['is_visible' => 'boolean'];
    public function scopeVisible($q) { return $q->where('is_visible', true); }
}
