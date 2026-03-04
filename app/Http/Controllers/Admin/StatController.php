<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Stat;
use Illuminate\Http\Request;

class StatController extends Controller {
    public function index() {
        $stats = Stat::orderBy('sort_order')->get();
        return view('admin.stats.index', compact('stats'));
    }
    public function create() { return view('admin.stats.create'); }
    public function store(Request $r) {
        $data = $r->validate(['label'=>'required','value'=>'required|integer','suffix'=>'nullable','icon'=>'nullable','sort_order'=>'integer','is_visible'=>'boolean']);
        $data['is_visible'] = $r->boolean('is_visible', true);
        $data['suffix'] = $data['suffix'] ?? '+';
        Stat::create($data);
        return redirect()->route('admin.stats.index')->with('success','Stat added.');
    }
    public function edit(Stat $stat) { return view('admin.stats.edit', compact('stat')); }
    public function update(Request $r, Stat $stat) {
        $data = $r->validate(['label'=>'required','value'=>'required|integer','suffix'=>'nullable','icon'=>'nullable','sort_order'=>'integer','is_visible'=>'boolean']);
        $data['is_visible'] = $r->boolean('is_visible', true);
        $data['suffix'] = $data['suffix'] ?? '+';
        $stat->update($data);
        return redirect()->route('admin.stats.index')->with('success','Stat updated.');
    }
    public function destroy(Stat $stat) {
        $stat->delete();
        return redirect()->route('admin.stats.index')->with('success','Stat deleted.');
    }
}
