<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'title', 'description', 'location', 'salary', 'expires_at',
    ];
    protected $casts = [
        'expires_at' => 'datetime',
    ];


    // User who uploaded this job
    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    
}
