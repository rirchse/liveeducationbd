<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    public function papers()
    {
        return $this->belongsToMany(Paper::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}