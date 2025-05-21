<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'name',
        'description',
        'client_id'
    ];

    public function teamMembers()
    {
        return $this->belongsToMany(User::class, 'chat_teams')->withTimestamps();
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'chat_package')->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    // public function participants()
    // {
    //     return $this->belongsToMany(User::class, 'chat_user');
    // }
}
