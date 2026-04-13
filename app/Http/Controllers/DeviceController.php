<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ZktecoDevices;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ZktecoConnectInterface as ZktDevice;


class DeviceController extends Controller
{
    public function index()
    {
        $devices = ZktecoDevices::latest()->get();
        $attendances = Attendance::latest()->get();
        return view('device.manageDevice', compact('devices'));
    }

    // Store device
    public function store(Request $request)
    {
        ZktecoDevices::create($request->all());
        return back()->with('success', 'Device added!');
    }

    // Delete
    public function destroy($id)
    {
        ZktecoDevices::findOrFail($id)->delete();
        return back()->with('success', 'Device deleted!');
    }

    // device configuration
    public function deviceInfo(Request $request, ZktDevice $zktDevice, $device_id)
    {
        try {
            session(['current_device_id' => $device_id]);
            $deviceInfo = $zktDevice->deviceInfo($device_id);
            $zktDeviceConfiguration = $zktDevice->deviceConfiguration($device_id);
            return view('device.deviceInfo', compact('zktDeviceConfiguration', 'deviceInfo'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function testSound(ZktDevice $zktDevice, $device_id)
    {
        try {
            $zktDevice->soundTest($device_id);
            return back()->with('success', 'Sound played!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function restartDevice(ZktDevice $zktDevice, $device_id)
    {
        try {
            $zktDevice->restartDevice($device_id);
            return back()->with('success', 'Device restarting...');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function shutdownDevice(ZktDevice $zktDevice, $device_id)
    {
        try {
            $zktDevice->shutdownDevice($device_id);
            return back()->with('success', 'Device shutting down...');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
