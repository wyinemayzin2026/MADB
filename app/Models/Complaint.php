<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrower_id',
        'from_email',
        'to_email',
        'subject',
        'body',
        'images',
        'status',
    ];
    protected $casts = [
        'images' => 'array',
    ];

    public function borrower()
    {
        return $this->belongsTo(Borrower::class, 'borrower_id');
    }
}
