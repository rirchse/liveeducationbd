<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
