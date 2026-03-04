<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller {
    public function index() {
        $testimonials = Testimonial::orderBy('sort_order')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }
    public function create() { return view('admin.testimonials.create'); }
    public function store(Request $r) {
        $data = $r->validate(['quote'=>'required','author_name'=>'required','author_location'=>'nullable','sort_order'=>'integer','is_visible'=>'boolean']);
        $data['is_visible'] = $r->boolean('is_visible', true);
        Testimonial::create($data);
        return redirect()->route('admin.testimonials.index')->with('success','Testimonial added.');
    }
    public function edit(Testimonial $testimonial) { return view('admin.testimonials.edit', compact('testimonial')); }
    public function update(Request $r, Testimonial $testimonial) {
        $data = $r->validate(['quote'=>'required','author_name'=>'required','author_location'=>'nullable','sort_order'=>'integer','is_visible'=>'boolean']);
        $data['is_visible'] = $r->boolean('is_visible', true);
        $testimonial->update($data);
        return redirect()->route('admin.testimonials.index')->with('success','Testimonial updated.');
    }
    public function destroy(Testimonial $testimonial) {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success','Testimonial deleted.');
    }
}
