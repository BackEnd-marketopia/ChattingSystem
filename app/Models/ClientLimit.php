<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientLimit extends Model
{
    protected $fillable = [
        'client_package_id',
        'item_type',
        'action_limit'
    ];
}
