<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomTeam extends Model
{
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function players() {
        return $this->hasMany('App\Models\Players');
    }
}
