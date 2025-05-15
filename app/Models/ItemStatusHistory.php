<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ItemStatusHistory extends Model
{
    protected $fillable = [
        'client_package_id',
        'item_id',
        'item_type',
        'status',
        'note',
        'updated_by',
    ];

    public function item()
    {
        return $this->belongsTo(ClientPackageItem::class, 'client_package_item_id');
    }

    public function clientPackage()
    {
        return $this->belongsTo(ClientPackage::class, 'client_package_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
