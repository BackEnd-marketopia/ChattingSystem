<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PackageItemUsage;

class PackageItem extends Model
{


    protected $fillable = [
        'package_id',
        'type',
        'status',
        'notes',
        'created_by',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }


    public function usages()
    {
        return $this->hasMany(PackageItemUsage::class);
    }

    public function allowedItem()
    {
        return $this->belongsTo(PackageAllowedItem::class, 'type', 'name');
    }
}
