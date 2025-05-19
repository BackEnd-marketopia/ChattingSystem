<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageAllowedItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_item_id',
        'allowed_count',
    ];

    public function packageItem()
    {
        return $this->belongsTo(PackageItem::class);
    }
}
