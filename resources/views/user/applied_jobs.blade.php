<!-- resources/views/user/applied_jobs.blade.php -->
@extends('layouts.app')

@section('title', 'My Applied Jobs')

@section('content')
<div class="container">
    <h1>Your Job Applications</h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Job Title</th>
                <th scope="col">Company</th>
                <th scope="col">Applied On</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($appliedJobs as $job)
            <tr>
                <td><a href="{{ route('jobs.show', $job->id) }}">{{ $job->title }}</a></td>
                <td>
                    @if($job->uploader->logo)
                        <img src="{{ Storage::url($job->uploader->logo) }}" alt="Company Logo" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                    @endif
                    {{ $job->uploader->name }}
                </td>
                <td>{{ $job->pivot->created_at->format('d-m-Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3">No job applications found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection



