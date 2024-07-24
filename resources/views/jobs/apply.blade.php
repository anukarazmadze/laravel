<!-- resources/views/user/applied_jobs.blade.php -->
@extends('layouts.app')

@section('title', 'Apply')

@section('content')
    <div class="container mt-4">
        <h1>Apply for {{ $job->title }}</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('jobs.storeApplication', $job->id) }}" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
            @csrf
            <div class="col-md-4">
                <label for="first_name" class="form-label">First name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
            </div>
            <div class="col-md-4">
                <label for="last_name" class="form-label">Last name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
            </div>
            <div class="mb-3">
                <label for="cover_letter" class="form-label">Cover Letter</label>
                <textarea class="form-control" id="cover_letter" name="cover_letter" rows="3">{{ old('cover_letter') }}</textarea>
            </div>
            <div class="col-md-6">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
            </div>
            <div class="col-md-6">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
            </div>
            <div class="mb-3">
                <label for="resume" class="form-label">Resume</label>
                <input class="form-control" type="file" id="resume" name="resume" required>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Apply</button>
            </div>
        </form>
    </div>
@endsection


