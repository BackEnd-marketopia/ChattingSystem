<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientPackage extends Model
{

    protected $table = 'client_package';

    protected $fillable = [
        'client_id',
        'package_id',
        'chat_id',
        'status',
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

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

    public function clientPackageItems()
    {
        return $this->hasMany(ClientPackageItem::class);
    }

    public function clientLimits()
    {
        return $this->hasMany(ClientLimit::class);
    }
}
