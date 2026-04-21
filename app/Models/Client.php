<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'users'; // أو 'clients' إذا عندك جدول

    protected $fillable = [
        'name',
        'phone',
        'email',
        'country',
        'city',
        'address',
        'type',
    ];
}
