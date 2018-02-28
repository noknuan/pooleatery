<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function product_category()
    {
        return $this->belongsTo('App\ProductCategory');
    }

    public function recipes()
    {
        return $this->hasMany('App\Recipe');
    }
}