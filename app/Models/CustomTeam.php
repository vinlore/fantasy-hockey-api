<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomTeam extends Model
{
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function players() {
        return $this->belongsToMany('App\Models\Player', 'custom_team_player')->withTimestamps();
    }
}
