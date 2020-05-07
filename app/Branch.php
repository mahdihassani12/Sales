<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
	protected $table="branches";
    protected $fillable =[
        "name", "phone", "email", "address","is_active"
    ];
}
