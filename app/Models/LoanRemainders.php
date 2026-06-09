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

    // LoanRemainder.php
    public function borrowerLoan()
    {
        return $this->belongsTo(BorrowerLoan::class, 'loan_id'); // သင့် table မှ foreign key အမှန်ကို ထည့်ပါ
    }
}
