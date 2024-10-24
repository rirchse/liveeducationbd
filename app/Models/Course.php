<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    
    public function filters()
    {
        return $this->belongsToMany(Filter::class);
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

    public function chapters()
    {
        return $this->belongsToMany(Chapter::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
