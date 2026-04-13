<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\ZktecoDevices;
use Illuminate\Support\Facades\Log;
use Rats\Zkteco\Lib\ZKTeco;
use App\Repositories\Contracts\ZktecoUserInterface;

class ZktecoUser implements ZktecoUserInterface
{
    public function getUsers($zktdevice, $deviceId)
    {
        $zk = $zktdevice->connectDevice($deviceId);
        $users = $zk->getUser();
        $zk->disconnect();
        return $users;
    }


    public function addUser($zktdevice, $request, $deviceId)
    {
        $zk = $zktdevice->connectDevice($deviceId);

        $users = $zk->getUser();
        foreach ($users as $user) {
            if ($user['userid'] == $request->userid) {
                return [
                    'status' => 'error',
                    'message' => 'User already exists!'
                ];
            } else if ($user['uid'] == $request->uid) {
                return [
                    'status' => 'error',
                    'message' => 'uid already exists!'
                ];
            }
        }


        $uid       = $request->uid;
        $userid    = $request->userid; // only numbers
        $name      = $request->name;
        $password  = $request->password;
        $role      = 0;
        $cardno    = "0012694937";

        $zk->setUser($uid, $userid, $name, $password, $role, $cardno);

        $zk->disconnect();

        return [
            'status' => 'success',
            'message' => 'User added successfully!'
        ];
    }


    public function updateUser($zktdevice, $request, $deviceId)
    {
        $zk = $zktdevice->connectDevice($deviceId);

        $uid       = $request->uid;
        $userid    = $request->userid; // only numbers
        $name      = $request->name;
        $password  = $request->password;
        $role      = 14; // admin 14 , user 4
        $cardno    = $request->cardno;

        $zk->setUser($uid, $userid, $name, $password, $role, $cardno);
        $zk->disconnect();

        return [
            'status' => 'success',
            'message' => 'User updated successfully!'
        ];
    }


    public function deleteUser($zktdevice, $uid, $deviceId)
    {
        $zk = $zktdevice->connectDevice($deviceId);
        $zk->removeUser($uid);
        $zk->disconnect();

        return [
            'status' => 'success',
            'message' => 'User deleted successfully!'
        ];
    }
}
