<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaFile extends Model
{
    protected $fillable = ['file_path', 'file_type'];

    public function related()
    {
        return $this->morphTo();
    }
}
