<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    public function player() {
        return $this->belongsTo('App\Models\Player');
    }
}
