<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'username', 'name', 'email', 'password', 'balance','net_value',
    ];
    public function purchases()
    {
        return $this->hasMany('App\Purchase');
    }
    public function watchlist()
    {
        return $this->hasMany('App\Stock');
    }
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $table = 'users';
}
