@extends('layouts.app')

@section('title', 'Applicant Details')

@section('content')
    <div class="container mt-4">
        <h1>Applicant Details</h1>
        <table class="table">
            <tr>
                <th>First Name</th>
                <td>{{ $applicant->first_name }}</td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td>{{ $applicant->last_name }}</td>
            </tr>
            <tr>
                <th>City</th>
                <td>{{ $applicant->city }}</td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td>{{ $applicant->phone_number }}</td>
            </tr>
            <tr>
                <th>Cover Letter</th>
                <td>{{ $applicant->cover_letter }}</td>
            </tr>
            <tr>
                <th>Resume</th>
                <td>
                    @if ($applicant->resume)
                        <a href="{{ Storage::url($applicant->resume) }}" target="_blank">View Resume</a>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
        </table>
        <a href="{{ route('company.jobs') }}" class="btn btn-primary">Back to Jobs</a>
    </div>
@endsection
