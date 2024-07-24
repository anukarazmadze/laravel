<!-- resources/views/jobs/create.blade.php -->

@extends('layouts.app')

@section('title', 'Create a Job')

@section('content')
    <div class="container mt-4">
        <h1>Create Job</h1>

        <!-- Display validation errors if any -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Job creation form -->
        <form action="{{ route('jobs.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Job Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Job Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" required>
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Salary</label>
                <input type="number" class="form-control" id="salary" name="salary" value="{{ old('salary') }}" step="0.01">
            </div>
            <div class="col-md-6">
                <label for="expires_at" class="form-label">Expiration Date</label>
                <input type="date" class="form-control" id="expires_at" name="expires_at" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Job</button>
        </form>
    </div>
@endsection
