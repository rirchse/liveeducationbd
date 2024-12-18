<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    // public function courses()
    // {
    //     return $this->belongsToMany(Course::class);
    // }

    // public function departments()
    // {
    //     return $this->belongsToMany(Department::class);
    // }

    // public function papers()
    // {
    //     return $this->belongsToMany(Paper::class);
    // }

    public function paper()
    {
        return $this->hasOne(Paper::class, 'group_id');
    }
    
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}