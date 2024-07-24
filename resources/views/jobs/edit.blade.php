@extends('layouts.app')

@section('title', 'Edit Job')

@section('content')
    <div class="container mt-4">
        <h1>Edit Job</h1>

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

        <!-- Job editing form -->
        <form action="{{ route('jobs.update', $job->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Specify the PUT method for updating -->
            <div class="mb-3">
                <label for="title" class="form-label">Job Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $job->title) }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Job Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $job->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $job->location) }}" required>
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Salary</label>
                <input type="number" class="form-control" id="salary" name="salary" value="{{ old('salary', $job->salary) }}" step="0.01">
            </div>
            <div class="mb-3">
                <label for="expires_at" class="form-label">Expiration Date</label>
                <input type="date" class="form-control" id="expires_at" name="expires_at" value="{{ old('expires_at', $job->expires_at->format('Y-m-d')) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Job</button>
        </form>
    </div>
@endsection
