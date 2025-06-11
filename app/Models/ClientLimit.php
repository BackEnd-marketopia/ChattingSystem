<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientLimit extends Model
{
    protected $table = "client_limits";

    protected $fillable = [
        'client_id',
        'client_package_id',
        'client_package_item_id',
        'item_type',
        'edit_limit',
        'decline_limit'
    ];


    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function clientPackage()
    {
        return $this->belongsTo(ClientPackage::class);
    }
}
