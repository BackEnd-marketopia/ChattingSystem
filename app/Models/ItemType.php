<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    protected $fillable = [
        'id',
        'name'
    ];


    public function items()
    {
        return $this->hasMany(PackageItem::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
