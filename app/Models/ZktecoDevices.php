<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZktecoDevices extends Model
{
    use HasFactory;

    protected $table = 'zkteco_devices';

    protected $fillable = [
        'id',
        'ip',
        'port',
        'model_name',
        'status'
    ];

    protected $dates = [
        'timestamp'
    ];
}
