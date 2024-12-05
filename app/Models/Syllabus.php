<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    
    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}