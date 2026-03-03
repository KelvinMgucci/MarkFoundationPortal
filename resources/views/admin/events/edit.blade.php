@extends('layouts.admin')
@section('title', 'Edit Event')
@section('breadcrumb')
    <a href="{{ route('admin.events.index') }}">Events</a>
    <span class="sep">/</span><span>Edit</span>
@endsection

@section('content')
<div class="page-hd">
    <div>
        <h1>Edit Event</h1>
        <p>{{ $event->title }}</p>
    </div>
    <div style="display:flex;gap:.625rem;align-items:center;">
        <span class="badge {{ $event->is_published ? 'badge-published' : 'badge-draft' }}">{{ $event->is_published ? 'Published' : 'Draft' }}</span>
        <a href="{{ route('events.show', $event) }}" class="btn btn-ghost btn-sm" target="_blank">View Live ↗</a>
    </div>
</div>

<form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.events._form')
</form>
@endsection
