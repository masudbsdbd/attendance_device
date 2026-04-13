<?php

use App\Models\Role;
use Carbon\Carbon;


function dateTimeConverter($datetime)
{
    $datetime = Carbon::parse($datetime);
    return $datetime->format('Y-m-d h:i:s A');
}


function roleConverter($device_id, $role)
{
    $role = Role::where('device_id', $device_id)->where('role_id', $role)->first();
    if ($role) {
        return $role->role_name;
    } else {
        return 'N/A';
    }
}
