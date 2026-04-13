<?php

namespace App\Repositories\Contracts;

interface ZktecoConnectInterface
{
    public function deviceInfo($deviceId);
    public function connectDevice($deviceId);
    public function deviceConfiguration($deviceId);
    public function soundTest($deviceId);
    public function restartDevice($deviceId);
    public function shutdownDevice($deviceId);
}
