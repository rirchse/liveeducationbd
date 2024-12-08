<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $guard = 'teacher';

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