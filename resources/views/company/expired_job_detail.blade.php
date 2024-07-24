@extends('layouts.app')

@section('title', 'Expired Job Details')

@section('content')

    <div class="container mt-4">
        <h1>Job Details</h1>
        
            <br>
                <h2 class="card-title">{{ $job->title }}</h2>
                <br>
                <p class="card-text"><strong>Location:</strong> {{ $job->location }}</p>
                <p class="card-text"><strong>Salary:</strong> {{ $job->salary }}</p>
                <p class="card-text"><strong>Expiration Date:</strong> {{ $job->expires_at->format('d-m-Y') }}</p>
                <p class="card-text"><strong>Description:</strong> {{ $job->description }}</p>
        <h2 class="pt-4">Applicants</h2>
        @foreach ($job->applications as $application)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $application->first_name }} {{ $application->last_name }}</h5>
                <p class="card-text"><strong>City:</strong> {{ $application->city }}</p>
                <p class="card-text"><strong>Phone:</strong> {{ $application->phone_number }}</p>
                <p class="card-text"><strong>Cover Letter:</strong> {{ $application->cover_letter }}</p>
                <a href="{{ route('resume.show', $application->id) }}" class="btn btn-primary">View Resume</a>
            </div>
        </div>
        @endforeach
        <a class="btn btn-primary mt-3" href="{{ route('company.jobs') }}">Back to Jobs</a>
    </div>
@endsection
