<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [

        'user_id',

        'user_name',

        'user_email',

        'role',

        'action',

        'module',

        'module_id',

        'description',

        'ip_address',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}