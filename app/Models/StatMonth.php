<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatMonth extends Model
{
    protected $table = 'stats_month';

    public function player() {
        return $this->belongsTo('App\Models\Player');
    }
}
