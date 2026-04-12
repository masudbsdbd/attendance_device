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



class AttendanceController extends Controller
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

            return view('device', compact('deviceInfo'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // $users = $this->zk->getUser();
    // $this->addUser($request);
    // $this->clearOldAttendance();
    // $this->zk->setTime($currentTime);
    // $this->zk->disconnect();
    // exit;

    public function getUsers(Request $request)
    {
        $users = $this->zk->getUser();
        return view('users.index', compact('users'));
    }

    public function index(Request $request)
    {
        try {
            $ip_address = $this->ip_address;
            $port = $this->port;
            $apiUrl = $this->apiUrl;
            $this->zk = new ZKTeco($ip_address, $port);

            if ($this->zk->connect()) {
                Log::info('Device connection successful');
            } else {
                Log::info('Failed to connect to ZKTeco device');
                return;
            }

            $attendanceRecords = $this->zk->getAttendance();
            dd($attendanceRecords);
            foreach ($attendanceRecords as $record) {
                $timestamp = $record['timestamp'];
                $timestamp_date = Carbon::parse($timestamp)->format('Y-m-d');
                $string = substr($this->zk->serialNumber(), strpos($this->zk->serialNumber(), "=") + 1);
                $serialNumber = preg_replace('/null|\0/i', '', $string);

                $exists = Attendance::where('uid', $record['uid'])
                    ->where('user_id', $record['id'])
                    ->where('timestamp', $timestamp)
                    ->exists();

                if (!$exists) {
                    Attendance::create([
                        'uid' => $record['uid'],
                        'user_id' => $record['id'],
                        'state' => $record['state'],
                        'timestamp' => $timestamp,
                        'type' => $record['type'],
                    ]);

                    $exists_check = InOut::where('user_id', $record['id'])
                        ->where('date', $timestamp_date)
                        ->exists();

                    if ($exists_check) {
                        $last_in = InOut::where('user_id', $record['id'])
                            ->where('date', $timestamp_date)
                            ->first()->in_time;
                        InOut::where('user_id', $record['id'])
                            ->where('date', $timestamp_date)->update([
                                'user_id' => $record['id'],
                                // 'in_time' => $last_in,
                                'out_time' => $record['timestamp'],
                                'time_calc' => DB::raw('TIMESTAMPDIFF(SECOND, in_time, out_time)'),
                                'date' => Carbon::parse($record['timestamp'])->format('Y-m-d')
                            ]);

                        $response = Http::post($apiUrl . "/insertAttendance", [
                            'employee_id' => $record['id'],
                            'clock_in' => $record['timestamp'],
                            'clock_out' => $record['timestamp'],
                            'status' => $serialNumber,
                            'date' => Carbon::parse($record['timestamp'])->format('Y-m-d')
                        ]);
                        // Log::info('Create Response status: ' . $response->status());
                        // Log::info('Create Response body: ' . $response->body());
                    } else {
                        InOut::create([
                            'user_id' => $record['id'],
                            'in_time' => $record['timestamp'],
                            'out_time' => $record['timestamp'],
                            'time_calc' => 0,
                            'date' => Carbon::parse($record['timestamp'])->format('Y-m-d')
                        ]);
                        $response = Http::post($apiUrl . "/insertAttendance", [
                            'employee_id' => $record['id'],
                            'clock_in' => $record['timestamp'],
                            'clock_out' => $record['timestamp'],
                            'status' => $serialNumber,
                            'date' => Carbon::parse($record['timestamp'])->format('Y-m-d')
                        ]);
                        Log::info('Create Response status: ' . $response->status());
                        Log::info('Create Response body: ' . $response->body());
                    }
                } else {
                    // Log::info('Duplicate attendance record found: ', $record);
                }
            }
        } catch (\Exception $e) {
            // Log::error('Error processing attendance: ' . $e->getMessage());
        }
    }



    public function addUser(Request $request)
    {
        $request->validate([
            'uid' => 'required|string|max:9',
            'userid' => 'required|string|max:9',
            'name' => 'required|string|max:24',
            'password' => 'required|string|max:8',
        ]);

        try {

            $users = $this->zk->getUser();
            foreach ($users as $user) {
                if ($user['userid'] == $request->userid) {
                    return redirect()->back()->with('error', 'User already exists!');
                } else if ($user['uid'] == $request->uid) {
                    return redirect()->back()->with('error', 'uid already exists!');
                }
            }

            $uid       = $request->uid;
            $userid    = $request->userid; // only numbers
            $name      = $request->name;
            $password  = $request->password;
            $role      = 0;
            $cardno    = "0012694937";

            $this->zk->setUser($uid, $userid, $name, $password, $role, $cardno);
            $this->zk->disconnect();

            return redirect()->back()->with('success', 'User added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e);
        }
    }


    public function EditUser(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'uid' => 'required|string|max:9',
            'userid' => 'required|string|max:9',
            'name' => 'required|string|max:24',
            'password' => 'required|string|max:8',
            'cardno' => 'required',
        ]);
        try {


            $uid       = $request->uid;
            $userid    = $request->userid; // only numbers
            $name      = $request->name;
            $password  = $request->password;
            $role      = 0;
            $cardno    = $request->cardno;

            $this->zk->setUser($uid, $userid, $name, $password, $role, $cardno);
            $this->zk->disconnect();

            return redirect()->back()->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e);
        }
    }


    public function deleteUser($uid)
    {
        try {
            $result = $this->zk->removeUser($uid);
            Log::info("Delete User Success: " . $result);
            $this->zk->disconnect();

            return redirect()->back()->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function clearOldAttendance()
    {
        $ip   = '192.168.0.201';
        $port = 4370;

        $zk = new ZKTeco($ip, $port);

        try {
            if (!$zk->connect()) {
                return response()->json(['status' => 'error', 'message' => 'Connection failed']);
            }

            // আগে সব logs নিয়ে ডাটাবেসে সেভ করো (নিরাপদ)
            $allLogs = $zk->getAttendance();

            if (!empty($allLogs)) {
                // এখানে তোমার save logic চালাও (updateOrCreate)
                // foreach (...) { Attendance::updateOrCreate(...); }
                echo "Total " . count($allLogs) . " records backed up.<br>";
            }

            // এখন clear করো
            $result = $zk->clearAttendance();

            $zk->disconnect();

            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'All attendance logs cleared from device successfully!'
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Failed to clear logs'
                ]);
            }
        } catch (\Exception $e) {
            if (isset($zk)) $zk->disconnect();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
