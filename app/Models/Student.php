<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    protected $guard = 'student';

    protected $fillable = [
        'name', 'contact', 'email', 'password', 'image', 'github_id', 'google_id', 'facebook_id'
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function batches()
    {
        return $this->belongsToMany(Batch::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}