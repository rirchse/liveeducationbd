<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    //
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function semesters()
    {
        return $this->belongsToMany(Semester::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
