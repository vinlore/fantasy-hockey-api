<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatWeek extends Model
{
    protected $table = 'stats_week';

    public function player() {
        return $this->belongsTo('App\Models\Player');
    }
}
