<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /// Fetch jobs that are not expired or soft-deleted
        $jobs = Job::with('uploader')
            ->where('expires_at', '>', now())           
            ->paginate(10);

        // Generate query string for pagination links
        $queryString = $request->query();

        return view('jobs.index', [
            'jobs' => $jobs,
            'queryString' => $queryString,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ensure the user is a company
        if (Auth::user()->role !== 'company') {
            return redirect()->route('jobs.index')->with('error', 'Unauthorized action.');
        }

        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'expires_at' => 'required|date|after:today', // Ensure expiration date is in the future
        ]);

        $job = new Job();
        $job->user_id = Auth::id(); // Set the user ID of the company posting the job
        $job->title = $validated['title'];
        $job->description = $validated['description'];
        $job->location = $validated['location'];
        $job->salary = $validated['salary'];
        $job->expires_at = $validated['expires_at']; // Use the expiration date from the form
        $job->save();

        return redirect()->route('jobs.index')->with('success', 'Job created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $job = Job::with('uploader')->findOrFail($id);
        return view('jobs.show', ['job' => $job]);
    }
    /**
     * Show the form for editing the specified resource.
     */

    // Display the job application form
    public function showApplyForm(Job $job)
    {
        return view('jobs.apply', ['job' => $job]);
    }

    public function edit(Job $job)
    {
        // Ensure the user is the owner of the job
        if (Auth::id() !== $job->user_id) {
            return redirect()->route('jobs.index')->with('error', 'Unauthorized action.');
        }

        return view('jobs.edit', ['job' => $job]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'expires_at' => 'required|date',
        ]);

        // Ensure the user is the owner of the job
        if (Auth::id() !== $job->user_id) {
            return redirect()->route('jobs.index')->with('error', 'Unauthorized action.');
        }

        $job->title = $request->title;
        $job->description = $request->description;
        $job->location = $request->location;
        $job->salary = $request->salary;
        $job->expires_at = $request->expires_at;
        $job->save();

        return redirect()->route('company.jobs')->with('success', 'Job updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        // Ensure the user is the owner of the job
        if (Auth::id() !== $job->user_id) {
            return redirect()->route('jobs.index')->with('error', 'Unauthorized action.');
        }

        $job->delete();

        return redirect()->route('company.jobs')->with('success', 'Job deleted successfully.');
    }

    public function apply(Job $job)
    {
        // Ensure the user is not a company
        if (Auth::user()->role === 'company') {
            return redirect()->route('jobs.index')->with('error', 'Unauthorized action.');
        }

        return view('jobs.apply', ['job' => $job]);


        // return redirect()->route('jobs.show', $job)->with('success', 'Applied to job successfully.');
    }

    public function storeApplication(Request $request, Job $job)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'cover_letter' => 'nullable|string',
            'city' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'local');

        JobApplication::create([
            'job_id' => $job->id,
            'user_id' => auth()->id(),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'cover_letter' => $validated['cover_letter'],
            'city' => $validated['city'],
            'phone_number' => $validated['phone_number'],
            'resume' => $resumePath,
        ]);

        // Attach the job to the user and vice versa
        $job->applicants()->attach(auth()->id());

        return redirect()->route('jobs.show', $job->id)->with('success', 'Your application has been submitted successfully.');
    }

    
    public function restoreJob($id)
    {
        $job = Job::withTrashed()->find($id);

        if ($job && $job->user_id === Auth::id()) {
            $job->restore();
            return redirect()->route('company.jobs')->with('success', 'Job restored successfully.');
        }

        return redirect()->route('company.jobs')->with('error', 'Unauthorized action or job not found.');
    }

    public function viewApplicants($jobId)
    {
        $job = Job::with('applicants')->findOrFail($jobId); 

        return view('jobs.applicants', compact('job', 'applicants'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Validate the query
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        // Search jobs
        $jobs = Job::with('uploader')
                    ->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->paginate(10);

        return view('jobs.index', compact('jobs'));
    }
}
