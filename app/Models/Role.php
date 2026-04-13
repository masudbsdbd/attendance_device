<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ZktecoDevices;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'role_name',
        'description',
        'role_id'
    ];


    public function device()
    {
        return $this->belongsTo(ZktecoDevices::class, 'device_id', 'id');
    }
}
