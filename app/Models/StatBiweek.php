<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatBiweek extends Model
{
    protected $table = 'stats_biweek';

    public function player() {
        return $this->belongsTo('App\Models\Player');
    }
}
