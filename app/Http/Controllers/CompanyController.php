<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function dashboard()
    {
        // Ensure the user is a company
        if (Auth::user()->role !== 'company') {
            return redirect()->route('jobs.index')->with('error', 'Unauthorized action.');
        }

        return view('company.dashboard');
    }

    public function index(Request $request)
    {
        if (Auth::user()->role !== 'company') {
            return redirect()->route('jobs.index')->with('error', 'Unauthorized action.');
        }

        // Fetch active jobs
        $activeJobs = Job::with(['uploader', 'applications'])
            ->where('user_id', Auth::id())
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->paginate(10);

        $deletedJobs = Job::onlyTrashed()
            ->where('user_id', Auth::id())
            ->get(); // Fetch deleted jobs

        // Fetch expired jobs
        $expiredJobs = Job::with('applicants')
            ->where('user_id', Auth::id())
            ->where('expires_at', '<=', now())
            ->whereNull('deleted_at')
            ->get();

        $queryString = $request->query();

        return view('company.jobs', [
            'activeJobs' => $activeJobs,
            'deletedJobs' => $deletedJobs, // Pass deleted jobs to the view
            'expiredJobs' => $expiredJobs,
            'queryString' => $queryString,
        ]);
    }

    public function showJob($id)
    {
        if (Auth::user()->role !== 'company') {
            return redirect()->route('jobs.index')->with('error', 'Unauthorized action.');
        }

        $job = Job::with('applications')->findOrFail($id);

        return view('company.job_detail', compact('job'));
    }

    public function restoreJob($id)
    {
        if (Auth::user()->role !== 'company') {
            return redirect()->route('jobs.index')->with('error', 'Unauthorized action.');
        }

        $job = Job::withTrashed()->findOrFail($id);

        if ($job->user_id !== Auth::id()) {
            return redirect()->route('company.jobs')->with('error', 'Unauthorized action.');
        }

        $job->restore();

        return redirect()->route('company.jobs')->with('success', 'Job restored successfully.');
    }

    public function showExpiredJob($id)
    {
        if (Auth::user()->role !== 'company') {
            return redirect()->route('jobs.index')->with('error', 'Unauthorized action.');
        }

        $job = Job::with('applicants')->findOrFail($id);

        return view('company.expired_job_detail', compact('job'));
    }

    public function editExpiredJob($id)
    {
        if (Auth::user()->role !== 'company') {
            return redirect()->route('jobs.index')->with('error', 'Unauthorized action.');
        }

        $job = Job::withTrashed()->findOrFail($id);

        if ($job->user_id !== Auth::id()) {
            return redirect()->route('company.jobs')->with('error', 'Unauthorized action.');
        }

        return view('company.edit_expired_job', compact('job'));
    }

    public function updateExpiredJob(Request $request, $id)
    {
        if (Auth::user()->role !== 'company') {
            return redirect()->route('jobs.index')->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'expires_at' => 'required|date|after:today',
        ]);

        $job = Job::withTrashed()->findOrFail($id);

        if ($job->user_id !== Auth::id()) {
            return redirect()->route('company.jobs')->with('error', 'Unauthorized action.');
        }

        $job->title = $validated['title'];
        $job->description = $validated['description'];
        $job->location = $validated['location'];
        $job->salary = $validated['salary'];
        $job->expires_at = $validated['expires_at'];
        $job->restore(); // Restore job if it was deleted
        $job->save();

        return redirect()->route('company.jobs')->with('success', 'Job updated and restored successfully.');
    }
}
