<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemUsageLog extends Model
{
    protected $fillable = [
        'client_package_id',
        'item_id',
        'item_type',
        'action',
        'note',
        'performed_by',
    ];

    
    public function item()
    {
        return $this->morphTo();
    }

    public function clientPackage()
    {
        return $this->belongsTo(ClientPackage::class);
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
