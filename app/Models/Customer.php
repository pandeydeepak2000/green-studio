<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'company_name',
        'phone',
        'email',
        'gst_number',
        'state',
        'address',
    ];
}