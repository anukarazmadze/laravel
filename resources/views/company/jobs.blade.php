@extends('layouts.app')

@section('title', 'My Jobs')

@section('content')
    <div class="container">
        <h1>Manage Your Jobs</h1>

        <!-- Active Jobs Section -->
        <h2>Active Jobs</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Job Title</th>
                    <th scope="col">Location</th>
                    <th scope="col">Salary</th>
                    <th scope="col">Expiration Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activeJobs as $job)
                <tr>
                    <td>{{ $job->title }}</td>
                    <td>{{ $job->location }}</td>
                    <td>{{ $job->salary }}</td>
                    <td>{{ $job->expires_at ? $job->expires_at->format('d-m-Y') : 'No Expiry' }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('jobs.show', $job->id) }}">View</a>
                        <a class="btn btn-warning btn-sm" href="{{ route('jobs.edit', $job->id) }}">Edit</a>
                        <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Expired Jobs Section -->
        <h2>Expired Jobs</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Job Title</th>
                    <th scope="col">Location</th>
                    <th scope="col">Salary</th>
                    <th scope="col">Expiration Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expiredJobs as $job)
                <tr>
                    <td>{{ $job->title }}</td>
                    <td>{{ $job->location }}</td>
                    <td>{{ $job->salary }}</td>
                    <td>{{ $job->expires_at->format('d-m-Y') }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('expired.job.show', $job->id) }}">View</a>
                        <a class="btn btn-warning btn-sm" href="{{ route('expired.job.edit', $job->id) }}">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <!-- Deleted Jobs Section -->
        <h2>Deleted Jobs</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Job Title</th>
                    <th scope="col">Location</th>
                    <th scope="col">Salary</th>
                    <th scope="col">Expiration Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deletedJobs as $job)
                <tr>
                    <td>{{ $job->title }}</td>
                    <td>{{ $job->location }}</td>
                    <td>{{ $job->salary }}</td>
                    <td>{{ $job->expires_at->format('d-m-Y') }}</td>
                    <td>
                        <form action="{{ route('jobs.restore', $job->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-success btn-sm" type="submit">Restore</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
