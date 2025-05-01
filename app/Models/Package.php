<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $casts = [
        'limits' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PackageItem::class);
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'chat_package')->withTimestamps();
    }
}
