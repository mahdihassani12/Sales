<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable =[

        "name", "address", "username", "password", "email", "phone", "extra1", "extra2", "extra3"
    ];
}
