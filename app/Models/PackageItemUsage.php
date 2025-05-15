<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageItemUsage extends Model
{
    protected $fillable = [
        'package_item_id',
        'action',
        'note'
    ];

    public function packageItem()
    {
        return $this->belongsTo(PackageItem::class);
    }
}
