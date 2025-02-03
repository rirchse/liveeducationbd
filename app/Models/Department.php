<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function semesters()
    {
        return $this->belongsToMany(Semester::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function chapters()
    {
        return $this->belongsToMany(Chapter::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    public function batches()
    {
        return $this->belongsToMany(Batch::class);
    }

    public function paper()
    {
        return $this->hasOne(Paper::class, 'department_id');
    }

    public function syllabus()
    {
        return $this->hasOne(Syllabus::class, 'department_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function complain()
    {
        return $this->hasOne(Complain::class, 'department_id');
    }
}
