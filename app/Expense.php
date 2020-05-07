<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable =[
        "date", "reference_no", "expense_category_id", "store_id", "amount", "note"  
    ];
}
