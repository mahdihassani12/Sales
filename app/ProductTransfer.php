<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTransfer extends Model
{
    protected $table = 'product_transfer';
    protected $fillable =[

        "transfer_id", "product_id", "qty", "unit", "net_unit_cost", "tax_rate", "tax", "total"
    ];
}
