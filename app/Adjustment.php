<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    protected $fillable =[
        "date", "reference_no", "store_id", "document", "total_qty", "item", "note","user_id","branch_id","type"   
    ];
}
