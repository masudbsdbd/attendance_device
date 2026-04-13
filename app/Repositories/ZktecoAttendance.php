<?php

namespace App\Repositories;

use App\Repositories\Contracts\ZktecoAttendanceInterface;

class ZktecoAttendance implements ZktecoAttendanceInterface
{
    public function attendanceLog($zktdevice, $deviceId)
    {
        $zk = $zktdevice->connectDevice($deviceId);
        $attendances = $zk->getAttendance();
        $zk->disconnect();
        return $attendances;
    }
}
