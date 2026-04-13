<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ZktecoConnectInterface as ZktDevice;
use App\Repositories\Contracts\ZktecoUserInterface as ZktUser;



class UserController extends Controller
{
    public function getUsers(Request $request, ZktDevice $zktDevice, ZktUser $zktUser, $device_id)
    {
        $users = $zktUser->getUsers($zktDevice, $device_id);
        return view('users.index', compact('users'));
    }


    public function addUser(Request $request, ZktDevice $zktDevice, ZktUser $zktUser, $device_id)
    {
        $request->validate([
            'uid' => 'required|string|max:9',
            'userid' => 'required|string|max:9',
            'name' => 'required|string|max:24',
            'password' => 'required|string|max:8',
            'role' => 'required|numeric',
        ]);
        try {
            $res =  $zktUser->addUser($zktDevice, $request, $device_id);
            return redirect()->back()->with($res['status'], $res['message']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function EditUser(Request $request, ZktDevice $zktDevice, ZktUser $zktUser, $device_id)
    {
        $request->validate([
            'uid' => 'required|string|max:9',
            'userid' => 'required|string|max:9',
            'name' => 'required|string|max:24',
            'password' => 'required|string|max:8',
            'cardno' => 'required',
        ]);
        try {
            $res =  $zktUser->updateUser($zktDevice, $request, $device_id);
            return redirect()->back()->with($res['status'], $res['message']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function deleteUser(ZktDevice $zktDevice, ZktUser $zktUser, $uid, $device_id)
    {
        try {
            $res =  $zktUser->deleteUser($zktDevice, $uid, $device_id);
            return redirect()->back()->with($res['status'], $res['message']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
