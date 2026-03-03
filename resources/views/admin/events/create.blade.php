@extends('layouts.admin')

@section('title', 'New Event')
@section('breadcrumb')
    <a href="{{ route('admin.events.index') }}">Events</a>
    <span class="sep">/</span><span>New</span>
@endsection

@section('content')
<div class="page-hd">
    <div><h1>New Event</h1><p>Create a new event to share with the community.</p></div>
</div>
<form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.events._form')
</form>
@endsection
