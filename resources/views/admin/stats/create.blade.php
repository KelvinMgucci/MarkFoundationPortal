@extends('layouts.admin')
@section('title','Add Stat')
@section('content')
<div style="margin-bottom:1.5rem;"><a href="{{ route('admin.stats.index') }}" style="color:var(--green);font-size:.85rem;">← Back</a><h1 style="font-size:1.5rem;font-family:var(--font-head);margin-top:.5rem;">Add Impact Stat</h1></div>
<style>.aform{background:#fff;border:1px solid var(--border);border-radius:12px;padding:2rem;max-width:580px;}.fg{margin-bottom:1.25rem;}.fg label{display:block;font-size:.82rem;font-weight:600;color:var(--ink-2);margin-bottom:.4rem;}.fg input{width:100%;padding:.65rem .9rem;border:1px solid var(--border-dk);border-radius:6px;font-family:var(--font-body);font-size:.9rem;}.row2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}.hint{font-size:.76rem;color:var(--ink-3);margin-top:.25rem;}</style>
<form action="{{ route('admin.stats.store') }}" method="POST" class="aform">
    @csrf
    <div class="fg"><label>Label *</label><input type="text" name="label" value="{{ old('label') }}" placeholder="e.g. Families Supported" required></div>
    <div class="row2">
        <div class="fg"><label>Value *</label><input type="number" name="value" value="{{ old('value') }}" placeholder="e.g. 150" required><p class="hint">The number to count up to</p></div>
        <div class="fg"><label>Suffix</label><input type="text" name="suffix" value="{{ old('suffix','+') }}" placeholder="+"><p class="hint">Shown after number e.g. +</p></div>
    </div>
    <div class="row2">
        <div class="fg"><label>Icon (emoji)</label><input type="text" name="icon" value="{{ old('icon','🌿') }}" placeholder="🏠"></div>
        <div class="fg"><label>Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order',0) }}"></div>
    </div>
    <div class="fg" style="display:flex;align-items:center;gap:.5rem;"><input type="checkbox" name="is_visible" value="1" id="vis" checked><label for="vis" style="margin:0;">Visible on website</label></div>
    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
    <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
        <button type="submit" class="btn btn-primary">Save Stat</button>
        <a href="{{ route('admin.stats.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection
