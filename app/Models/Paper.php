<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    public function questions()
    {
        return $this->belongsToMany(Paper::class);
    }
}
