<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusItem extends Model
{
    protected $table = "bonus_items";

    protected $fillable = [
        'package_id',
        'client_id',
        'item_type',
        'quantity',
        'is_static',
        'is_claimed',
        'note'
    ];


    protected $casts = [
        'is_static' => 'boolean',
        'is_dynamic' => 'boolean',
        'delivered' => 'boolean',
        'delivery_date' => 'datetime',
    ];

    public function clientPackage()
    {
        return $this->belongsTo(ClientPackage::class);
    }


    // public function package()
    // {
    //     return $this->belongsTo(Package::class);
    // }

    // public function client()
    // {
    //     return $this->belongsTo(User::class, 'client_id');
    // }


}
