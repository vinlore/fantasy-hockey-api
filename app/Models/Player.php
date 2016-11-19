<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function team() {
        return $this->belongsTo('App\Models\Team');
    }

    public function statsYear() {
        return $this->hasMany('App\Models\StatYear');
    }

    public function statsMonth() {
        return $this->hasOne('App\Models\StatMonth');
    }

    public function statsBiweek() {
        return $this->hasOne('App\Models\StatBiweek');
    }

    public function statsWeek() {
        return $this->hasOne('App\Models\StatWeek');
    }

    public function customTeams() {
        return $this->belongsToMany('App\Models\CustomTeam', 'custom_team_player')->withTimestamps();
    }
}
