<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    // public function paper()
    // {
    //     return $this->hasOne(Paper::class, 'group_id');
    // }

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}