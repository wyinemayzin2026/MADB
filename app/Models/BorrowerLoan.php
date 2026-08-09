<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowerLoan extends Model
{
    protected $guarded = [];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'borrower_loan_id');
    }

    // In app/Models/BorrowerLoan.php
    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    public function loanRemainder()
    {
        return $this->hasOne(LoanRemainders::class, 'loan_id');
    }
}
