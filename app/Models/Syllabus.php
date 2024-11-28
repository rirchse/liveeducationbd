<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}