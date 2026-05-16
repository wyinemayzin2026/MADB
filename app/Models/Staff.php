<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'staff';

    protected $fillable = [
        'eid',
        'nrc',
        'name',
        'address',
        'phone',
        'email',
        'position',    // ရာထူး
        'role',        // System Role (admin/staff)
        'image_path',  // ပုံလမ်းကြောင်း
        'password',    // လျှို့ဝှက်နံပါတ်
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Laravel 10+ တွင် password ကို အလိုအလျောက် hash လုပ်ပေးရန်
    ];

    public function getProfileImageAttribute()
    {
        return $this->image_path
            ? asset('storage/' . $this->image_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=6366f1&color=fff';
    }
}
