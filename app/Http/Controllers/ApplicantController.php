<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    public function show($id)
    {
        $applicant = JobApplication::findOrFail($id);

        return view('company.applications', compact('applicant'));
    }

    // Method to show jobs the user has applied to
    public function showAppliedJobs()
    {
        $user = Auth::user();
        $appliedJobs = $user->appliedJobs; // Retrieve the jobs the user has applied to

        return view('user.applied_jobs', compact('appliedJobs'));
    }
}
