<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    public function item()
    {
        return $this->belongsTo('App\Item');
    }
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}