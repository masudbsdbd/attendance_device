<?php

namespace App\Repositories\Contracts;

interface ZktecoAttendanceInterface
{
    public function attendanceLog($zktDevice, $deviceId);
    public function clearAttendanceLog($zktDevice, $deviceId);
}
