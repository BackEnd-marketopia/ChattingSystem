<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPackageItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_package_id',
        'item_type',
        'package_item_id',
        'content',
        'media_url',
        'status',
        'client_note',
        'handled_by',
    ];



    public function packageItem()
    {
        return $this->belongsTo(PackageItem::class);
    }

    public function clientPackage()
    {
        return $this->belongsTo(ClientPackage::class);
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function itemUsageLogs()
    {
        return $this->hasMany(ItemUsageLog::class);
    }

    public function itemStatusHistories()
    {
        return $this->hasMany(ItemStatusHistory::class);
    }

    public function mediaFiles()
    {
        return $this->morphMany(MediaFile::class, 'related');
    }
}
