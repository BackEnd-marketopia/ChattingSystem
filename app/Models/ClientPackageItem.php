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
        'original_item_id',
        'content',
        'media_url',
        'status',
        'client_note',
        'handled_by',
    ];

    public function clientPackage()
    {
        return $this->belongsTo(ClientPackage::class);
    }

    public function user()
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
}
