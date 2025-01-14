<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McqItem extends Model
{
    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
