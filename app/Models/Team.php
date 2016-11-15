<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function players() {
        return $this->hasMany('App\Models\Player');
    }
}
