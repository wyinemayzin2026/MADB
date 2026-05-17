<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrower extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'nrc_number',
        'phone_number',
        'date_of_birth',
        'gender',
        'email',
        'address',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
