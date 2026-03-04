<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model {
    protected $fillable = ['name','role','bio','email','phone','photo','sort_order','is_visible'];
    protected $casts = ['is_visible' => 'boolean'];
    public function scopeVisible($q) { return $q->where('is_visible', true); }
}
