<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Store extends Model
{
	protected $table = 'product_store';
    protected $fillable =[

        "product_id", "store_id", "qty"
    ];
}
