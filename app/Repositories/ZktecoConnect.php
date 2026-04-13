<?php

namespace App\Repositories;

use App\Models\ZktecoDevices;
use Illuminate\Support\Facades\Log;
use Rats\Zkteco\Lib\ZKTeco;
use App\Repositories\Contracts\ZktecoConnectInterface;

class ZktecoConnect implements ZktecoConnectInterface
{
    public function deviceInfo($deviceId)
    {
        $device = ZktecoDevices::findOrFail($deviceId);
        return $device;
    }

    public function connectDevice($deviceId)
    {
        $device = $this->deviceInfo($deviceId);
        $ip = $device->ip;
        $port = $device->port;
        $zk = new ZKTeco($ip, $port);
        if ($zk->connect()) {
            Log::info('Device connection successful');
        } else {
            Log::info('Failed to connect to ZKTeco device');
            return;
        }

        return $zk;
    }

    public function deviceConfiguration($deviceId)
    {
        $deviceInfo = $this->deviceInfo($deviceId);
        $zk = $this->connectDevice($deviceId);
        $attendanceDeviceInfo = [
            'ip'        => $deviceInfo['ip'],
            'port'      => $deviceInfo['port'],
            'platform'  => $zk->platform(),
            'os'        => $zk->osVersion(),
            'firmware'  => $zk->fmVersion(),
            'serial'    => $zk->serialNumber(),
            'device_name' => $zk->deviceName(),
            'time'      => $zk->getTime(),
        ];

        $zk->disconnect();

        return $attendanceDeviceInfo;
    }


    public function soundTest($deviceId)
    {
        $zk = $this->connectDevice($deviceId);
        $zk->testVoice();
        $zk->disconnect();
    }

    public function restartDevice($deviceId)
    {
        $zk = $this->connectDevice($deviceId);
        $zk->restart();
        $zk->disconnect();
    }


    public function shutdownDevice($deviceId)
    {
        $zk = $this->connectDevice($deviceId);
        $zk->shutdown();
        $zk->disconnect();
    }
}
