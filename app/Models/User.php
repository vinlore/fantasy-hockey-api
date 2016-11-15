<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    protected $fillable = [
        'username',
        'password'
    ];

    protected $guarded = ['token'];

    public function customTeams() {
        return $this->hasMany('App\Models\CustomTeam');
    }
}
