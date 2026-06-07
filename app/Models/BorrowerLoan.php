<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowerLoan extends Model
{
    protected $guarded = [];

    // In app/Models/BorrowerLoan.php
    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }
}
