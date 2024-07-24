@extends('layouts.app')

@section('title', 'Job Details')

@section('content')
    <div class="container mt-4">
        <h1>{{ $job->title }}</h1>
        <p><strong>Company:</strong> @if($job->uploader->logo)
            <img src="{{ Storage::url($job->uploader->logo) }}" alt="Company Logo" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
            @endif {{ $job->uploader->name }} </p>
        <p><strong>Description:
        <br>
        </strong> {{ $job->description }}</p>
        @if($job->salary)
        <p><strong>Salary:</strong> {{ $job->salary }}</p>
        @endif
        <p><strong>Published:</strong> {{ $job->created_at->format('d-m-Y') }}</p>
        <p><strong>Deadline:</strong> {{ $job->expires_at->format('d-m-Y') }}</p>

        @auth
        @if(Auth::user()->role === 'job_seeker' && $job->expires_at > now())
        <a href="{{ route('jobs.apply', $job->id) }}" class="btn btn-primary">Apply</a>
        @endif
        @if(Auth::user()->role === 'company' && Auth::user()->id === $job->user_id)
        <a class="btn btn-warning btn-sm" href="{{ route('jobs.edit', $job->id) }}">Edit</a>
        <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
        </form>
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
        @endif
        @else
        <p><a href="{{ route('login') }}">log in</a> to apply</p>
        @endauth
    </div>
@endsection
