<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Console\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    public function show($id)
    {
        $application = JobApplication::findOrFail($id);

        // Check if the logged-in user is authorized to view the resume
        if (auth()->user()->role !== 'company' || auth()->user()->id !== $application->job->user_id) {
            abort(403, 'Unauthorized access');
        }

        $resumePath = $application->resume;

        if (Storage::disk('local')->exists($resumePath)) {
            return response()->file(storage_path('app/' . $resumePath));
        }

        abort(404, 'File not found');
    }
}
