@extends('layouts.app')

@section('title', 'Edit Expired Job')

@section('content')
    <div class="container">
        <h1>Edit Job</h1>
        <form action="{{ route('expired.job.update', $job->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Job Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $job->title) }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $job->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $job->location) }}" required>
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Salary</label>
                <input type="number" class="form-control" id="salary" name="salary" value="{{ old('salary', $job->salary) }}">
            </div>
            <div class="mb-3">
                <label for="expires_at" class="form-label">Expiration Date</label>
                <input type="date" class="form-control" id="expires_at" name="expires_at" value="{{ old('expires_at', $job->expires_at->format('Y-m-d')) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Job</button>
        </form>
        <a class="btn btn-secondary mt-3" href="{{ route('company.jobs') }}">Back to Jobs</a>
    </div>
@endsection
