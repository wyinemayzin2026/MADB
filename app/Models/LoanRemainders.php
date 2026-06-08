<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanRemainders extends Model
{
    protected $table = 'loan_remainders';
    protected $guarded = [];

    protected $casts = [
        'net_total_repayment_amount' => 'decimal:2',
    ];
}
