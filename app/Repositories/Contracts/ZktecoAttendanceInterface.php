<?php

namespace App\Repositories\Contracts;

interface ZktecoAttendanceInterface
{
    public function attendanceLog($zktDevice, $deviceId);
}
