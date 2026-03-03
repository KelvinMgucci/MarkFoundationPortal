@extends('layouts.admin')

@section('title', 'Edit: ' . $job->title)
@section('breadcrumb')
    <a href="{{ route('admin.jobs.index') }}">Job Postings</a>
    <span class="sep">/</span>
    <span>Edit</span>
@endsection

@section('content')

<div class="page-hd">
    <div>
        <h1>Edit Posting</h1>
        <p>{{ $job->title }}</p>
    </div>
    <span class="badge badge-{{ $job->status }}" style="align-self:center;">{{ ucfirst($job->status) }}</span>
</div>

<form method="POST" action="{{ route('admin.jobs.update', $job) }}">
    @csrf
    @method('PUT')
    @include('admin.jobs._form')
</form>

@endsection
