<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['client_id'];

    public function teamMembers()
    {
        return $this->belongsToMany(User::class, 'chat_teams');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'chat_package')->withTimestamps();
    }
}
