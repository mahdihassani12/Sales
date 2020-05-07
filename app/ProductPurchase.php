<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    protected $table = 'product_purchases';
    protected $fillable =[

        "purchase_id", "product_id", "qty", "recieved", "unit", "net_unit_cost", "discount", "tax_rate", "tax", "total"
    ];
}
