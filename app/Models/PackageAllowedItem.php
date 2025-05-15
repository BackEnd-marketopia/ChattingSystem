<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageAllowedItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'item_type',
        'allowed_quantity',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}