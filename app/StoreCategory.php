<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreCategory extends Model
{
	protected $table="store_category"; 
    protected $fillable =[

        "name", "description","branch_id","is_active"
    ];
}
