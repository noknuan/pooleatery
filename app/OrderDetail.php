<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
    public function menu(){
        return $this->belongsTo('App\Menu');
    }
}