<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['chat_id', 'sender_id', 'message', 'client_package_item_id'];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function mediaFiles()
    {
        return $this->morphMany(MediaFile::class, 'related');
    }

    public function clientPackageItem()
    {
        return $this->belongsTo(ClientPackageItem::class);
    }
}
