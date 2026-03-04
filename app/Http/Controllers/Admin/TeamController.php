<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller {
    public function index() {
        $members = TeamMember::orderBy('sort_order')->get();
        return view('admin.team.index', compact('members'));
    }
    public function create() { return view('admin.team.create'); }
    public function store(Request $r) {
        $data = $r->validate(['name'=>'required','role'=>'required','bio'=>'nullable','email'=>'nullable|email','phone'=>'nullable','sort_order'=>'integer','is_visible'=>'boolean','photo'=>'nullable|image|max:2048']);
        if ($r->hasFile('photo')) $data['photo'] = $r->file('photo')->store('team','public');
        $data['is_visible'] = $r->boolean('is_visible', true);
        TeamMember::create($data);
        return redirect()->route('admin.team.index')->with('success','Team member added.');
    }
    public function edit(TeamMember $team) { return view('admin.team.edit', compact('team')); }
    public function update(Request $r, TeamMember $team) {
        $data = $r->validate(['name'=>'required','role'=>'required','bio'=>'nullable','email'=>'nullable|email','phone'=>'nullable','sort_order'=>'integer','is_visible'=>'boolean','photo'=>'nullable|image|max:2048']);
        if ($r->hasFile('photo')) {
            if ($team->photo) Storage::disk('public')->delete($team->photo);
            $data['photo'] = $r->file('photo')->store('team','public');
        }
        $data['is_visible'] = $r->boolean('is_visible', true);
        $team->update($data);
        return redirect()->route('admin.team.index')->with('success','Team member updated.');
    }
    public function destroy(TeamMember $team) {
        if ($team->photo) Storage::disk('public')->delete($team->photo);
        $team->delete();
        return redirect()->route('admin.team.index')->with('success','Team member deleted.');
    }
}
