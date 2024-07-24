@extends('layouts.app')

@section('title', 'Jobs')

@section('content')
<div class="container mt-4">
    <h2>Available Jobs</h2>

    <!-- Search Form -->
    <form class="d-flex mb-4" role="search" method="GET" action="{{ route('search') }}">
        <input class="form-control me-2" type="search" name="query" placeholder="Search jobs" aria-label="Search" value="{{ request()->input('query') }}">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>

    @if($jobs->count())
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Job Title</th>
                    <th scope="col"></th>
                    <th scope="col">Provided By</th>
                    <th scope="col">Published</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jobs as $job)
                <tr>
                    <td><a href="{{ route('jobs.show', $job->id) }}">{{ $job->title }}</a></td>
                    <td>
                        @if($job->uploader->logo)
                        <img src="{{ Storage::url($job->uploader->logo) }}" alt="Company Logo" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                        @endif
                    </td>
                    <td>{{ $job->uploader->name }}</td> <!-- Display the name of the company -->
                    <td>{{ $job->created_at->format('d-m-Y') }}</td>
                    <td>{{ $job->expires_at ? $job->expires_at->format('d-m-Y') : 'N/A' }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('jobs.show', $job->id) }}">View</a>
                        @auth
                        @if (Auth::user()->role === 'company' && Auth::user()->id === $job->user_id)
                        <a class="btn btn-warning btn-sm" href="{{ route('jobs.edit', $job->id) }}">Edit</a>
                        <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                        </form>
                        @else
                        @if (Auth::user()->role === 'job_seeker')
                        <a class="btn btn-primary btn-sm" href="{{ route('jobs.apply', $job->id) }}">Apply</a>
                        @endif
                        @endif
                        @else
                        <a class="btn btn-primary btn-sm" href="{{ route('login') }}">Login to Apply</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        {{ $jobs->appends(request()->query())->links() }}
    @else
        <p>No jobs found.</p>
    @endif
</div>
@endsection

