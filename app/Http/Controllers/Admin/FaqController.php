<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller {
    public function index() {
        $faqs = Faq::orderBy('sort_order')->get();
        return view('admin.faqs.index', compact('faqs'));
    }
    public function create() { return view('admin.faqs.create'); }
    public function store(Request $r) {
        $data = $r->validate(['question'=>'required','answer'=>'required','sort_order'=>'integer','is_visible'=>'boolean']);
        $data['is_visible'] = $r->boolean('is_visible', true);
        Faq::create($data);
        return redirect()->route('admin.faqs.index')->with('success','FAQ added.');
    }
    public function edit(Faq $faq) { return view('admin.faqs.edit', compact('faq')); }
    public function update(Request $r, Faq $faq) {
        $data = $r->validate(['question'=>'required','answer'=>'required','sort_order'=>'integer','is_visible'=>'boolean']);
        $data['is_visible'] = $r->boolean('is_visible', true);
        $faq->update($data);
        return redirect()->route('admin.faqs.index')->with('success','FAQ updated.');
    }
    public function destroy(Faq $faq) {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success','FAQ deleted.');
    }
}
