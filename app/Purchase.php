<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
	protected $fillable = [
        'user_id', 'stock_id', 'quantity',
    ];
    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function stock()
    {
        return $this->hasOne('App\Stock');
    }
    protected $table = 'purchase';
    protected $guarded = array('stock_id','user_id');
}
