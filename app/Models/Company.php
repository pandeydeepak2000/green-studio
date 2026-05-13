<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'gstin',
        'state',
        'state_code',
        'address',
        'phone',
        'email',
        'show_logo_on_invoice',
        'bank_name',
        'bank_account',
        'bank_ifsc',
        'bank_branch',
        'logo_path',
        'signature_path',
        'is_default',
    ];
}