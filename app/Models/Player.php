<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function team() {
        return $this->belongsTo('App\Models\Team');
    }

    public function stats() {
        return $this->hasMany('App\Models\Stat');
    }

    public function customTeams() {
        return $this->belongsToMany('App\Models\CustomTeam', 'custom_team_player')->withTimestamps();
    }
}
