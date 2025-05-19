<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'chat_package')->withTimestamps();
    }


    protected $casts = [];

    public function packageItems()
    {
        return $this->hasMany(PackageItem::class);
    }

    public function clients()
    {
        return $this->belongsToMany(User::class, 'client_package')
            ->withPivot(['start_date', 'end_date'])
            ->withTimestamps();
    }
}
