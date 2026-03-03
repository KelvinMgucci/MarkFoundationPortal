@extends('layouts.admin')

@section('title', 'New Job Posting')
@section('breadcrumb')
    <a href="{{ route('admin.jobs.index') }}">Job Postings</a>
    <span class="sep">/</span>
    <span>New</span>
@endsection

@section('content')

<div class="page-hd">
    <div>
        <h1>New Job Posting</h1>
        <p>Fill in the details to publish a new open position.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.jobs.store') }}">
    @csrf
    @include('admin.jobs._form')
</form>

@endsection
