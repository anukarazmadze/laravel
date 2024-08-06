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

    // ApplicantController.php
    public function showAppliedJobs()
    {
        $user = Auth::user();
        $jobApplications = JobApplication::where('user_id', $user->id)
            ->with('job')
            ->get();

        return view('user.applied_jobs', compact('jobApplications'));
    }
}
