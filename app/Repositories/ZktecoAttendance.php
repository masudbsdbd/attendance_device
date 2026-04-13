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


    public function clearAttendanceLog($zktdevice, $deviceId)
    {
        $zk = $zktdevice->connectDevice($deviceId);
        $allLogs = $zk->getAttendance();
        if (!empty($allLogs)) {
            echo "Total " . count($allLogs) . " records backed up.<br>";
        }
        $zk->clearAttendance();
        $zk->disconnect();

        return true;
    }
}
