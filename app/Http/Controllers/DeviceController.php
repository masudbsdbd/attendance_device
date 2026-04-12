<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\InOut;
use App\Models\ZktecoDevices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Rats\Zkteco\Lib\ZKTeco;
use Illuminate\Support\Facades\Http;



class DeviceController extends Controller
{

    private $zk;
    private $apiUrl;
    private $ip_address;
    private $port;

    public function __construct()
    {
        $this->apiUrl = "https://bsderp.test/api";
        $this->ip_address = "192.168.0.201";
        $this->port = 4370; // Default to 4370 if not provided
        $this->zk = new ZKTeco($this->ip_address, $this->port);
        if ($this->zk->connect()) {
            Log::info('Device connection successful');
        } else {
            Log::info('Failed to connect to ZKTeco device');
            return;
        }
    }



    public function deviceInfo()
    {
        $ip = $this->ip_address;
        $port = $this->port;
        $zk = new ZKTeco($ip, $port);

        try {
            if (!$zk->connect()) {
                return back()->with('error', 'Device connect failed');
            }


            $deviceInfo = [
                'ip'        => $ip,
                'port'      => $port,
                'platform'  => $zk->platform(),
                'os'        => $zk->osVersion(),
                'firmware'  => $zk->fmVersion(),
                'serial'    => $zk->serialNumber(),
                'device_name' => $zk->deviceName(),
                'time'      => $zk->getTime(),
            ];

            // dd($deviceInfo);

            $zk->disconnect();

            return view('device.device', compact('deviceInfo'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function testSound()
    {
        $zk = new ZKTeco($this->ip_address, $this->port);

        try {
            if ($zk->connect()) {
                $zk->testVoice();
                $zk->disconnect();
            }

            return back()->with('success', 'Sound played!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function restartDevice()
    {
        $zk = new ZKTeco($this->ip_address, $this->port);

        try {
            if ($zk->connect()) {
                $zk->restart();
                $zk->disconnect();
            }

            return back()->with('success', 'Device restarting...');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function shutdownDevice()
    {
        $zk = new ZKTeco($this->ip_address, $this->port);

        try {
            if ($zk->connect()) {
                $zk->shutdown();
                $zk->disconnect();
            }

            return back()->with('success', 'Device shutting down...');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
