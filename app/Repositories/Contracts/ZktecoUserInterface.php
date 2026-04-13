<?php

namespace App\Repositories\Contracts;

interface ZktecoUserInterface
{
    public function getUsers($zktdevice, $deviceId);
    public function addUser($zktdevice, $request, $deviceId);
    public function updateUser($zktdevice, $request, $deviceId);
    public function deleteUser($zktdevice, $uid, $deviceId);
}
