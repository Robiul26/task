<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // protected $guarded = [];

    protected $fillable = ['branch_id', 'first_name', 'last_name', 'email', 'phone','gender'];
}
