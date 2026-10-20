<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'facebook',
        'x',
        'linkedin',
        'instagram',
        'github',
        'whatsapp',
        'youtube',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
