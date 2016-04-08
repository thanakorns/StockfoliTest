<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
	protected $fillable = [
        'company_name', 'ticker', 'current_price', 'previous_price',
    ];
    public function owned()
    {
        return $this->hasMany('App\Purchase');
    }
    protected $table = 'stock';
}
