<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McqItem extends Model
{
    protected $fillable = ['items', 'question_id'];

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
