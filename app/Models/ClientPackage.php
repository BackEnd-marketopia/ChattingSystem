<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientPackage extends Model
{
    protected $fillable = [
        'client_id',
        'package_id',
        'status',
        'chat_id'
    ];


    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function packageItems()
    {
        return $this->hasMany(PackageItem::class);
    }

    public function usageLogs()
    {
        return $this->hasMany(ItemUsageLog::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(ItemStatusHistory::class);
    }
}
