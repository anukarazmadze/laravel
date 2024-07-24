<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'user_id',
        'first_name',
        'last_name',
        'cover_letter',
        'city',
        'phone_number',
        'resume',
    ];

    // The job for which this application was submitted
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    // The user who submitted the application
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

