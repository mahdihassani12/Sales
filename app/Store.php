<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable =[

        "name", "phone", "email", "address","store_category_id","branch_id" ,"is_active"
    ];
}
