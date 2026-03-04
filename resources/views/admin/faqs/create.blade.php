@extends('layouts.admin')
@section('title','Add FAQ')
@section('content')
<div style="margin-bottom:1.5rem;"><a href="{{ route('admin.faqs.index') }}" style="color:var(--green);font-size:.85rem;">← Back</a><h1 style="font-size:1.5rem;font-family:var(--font-head);margin-top:.5rem;">Add FAQ</h1></div>
<style>.aform{background:#fff;border:1px solid var(--border);border-radius:12px;padding:2rem;max-width:680px;}.fg{margin-bottom:1.25rem;}.fg label{display:block;font-size:.82rem;font-weight:600;color:var(--ink-2);margin-bottom:.4rem;}.fg input,.fg textarea{width:100%;padding:.65rem .9rem;border:1px solid var(--border-dk);border-radius:6px;font-family:var(--font-body);font-size:.9rem;}.fg textarea{resize:vertical;min-height:110px;}.row2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}</style>
<form action="{{ route('admin.faqs.store') }}" method="POST" class="aform">
    @csrf
    <div class="fg"><label>Question *</label><input type="text" name="question" value="{{ old('question') }}" required></div>
    <div class="fg"><label>Answer *</label><textarea name="answer" required>{{ old('answer') }}</textarea></div>
    <div class="row2">
        <div class="fg"><label>Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order',0) }}"></div>
        <div class="fg" style="display:flex;align-items:center;gap:.5rem;margin-top:1.5rem;"><input type="checkbox" name="is_visible" value="1" id="vis" checked><label for="vis" style="margin:0;">Visible on website</label></div>
    </div>
    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
    <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
        <button type="submit" class="btn btn-primary">Save FAQ</button>
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection
