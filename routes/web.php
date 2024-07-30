<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;



// Public Routes
Route::get('/', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
Route::get('/search', [JobController::class, 'search'])->name('search');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Job Creation and Management
    Route::get('/job/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/job', [JobController::class, 'store'])->name('jobs.store');
    Route::get('/job/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::put('/job/{job}', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('/job/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');

    // Apply and Store Application
    Route::get('/jobs/{job}/apply', [JobController::class, 'apply'])->name('jobs.apply');
    Route::post('/jobs/{job}/apply', [JobController::class, 'storeApplication'])->name('jobs.storeApplication');

    // Company Routes
    Route::get('/company/jobs', [CompanyController::class, 'index'])->name('company.jobs');
    Route::get('/company/jobs/{id}', [CompanyController::class, 'showJob'])->name('company.job.show');
    Route::put('/jobs/{job}/restore', [CompanyController::class, 'restoreJob'])->name('jobs.restore');

    // Applicant Details
    Route::get('/company/applications/{id}', [ApplicantController::class, 'show'])->name('applications.show');

    Route::get('/resume/{id}', [ResumeController::class, 'show'])->name('resume.show');

    // Route to view an expired job
    Route::get('/company/expired-jobs/{id}', [CompanyController::class, 'showExpiredJob'])->name('expired.job.show');

    // Route to edit an expired job
    Route::get('/company/expired-jobs/{id}/edit', [CompanyController::class, 'editExpiredJob'])->name('expired.job.edit');
    Route::put('/company/expired-jobs/{id}', [CompanyController::class, 'updateExpiredJob'])->name('expired.job.update');

    // Routes for ApplicantController
    Route::get('/applied-jobs', [ApplicantController::class, 'showAppliedJobs'])->name('user.applied_jobs');

    
});


require __DIR__ . '/auth.php';
