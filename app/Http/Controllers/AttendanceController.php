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
use App\Repositories\Contracts\ZktecoConnectInterface as ZktDevice;
use App\Repositories\Contracts\ZktecoUserInterface as ZktUser;
use App\Repositories\Contracts\ZktecoAttendanceInterface as ZktAttendance;



class AttendanceController extends Controller
{
    // $this->zk->setTime($currentTime);
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

    public function attendanceLog(ZktDevice $zktdevice, ZktAttendance $zktAttendance, $device_id)
    {
        $attendanceRecords = $zktAttendance->attendanceLog($zktdevice, $device_id);
        return view('attendances.attendanceManagement', compact('attendanceRecords'));
    }

    public function clearAttendanceLog(ZktDevice $zktdevice, ZktAttendance $zktAttendance, $device_id)
    {
        try {
            $zktAttendance->clearAttendanceLog($zktdevice, $device_id);
            return redirect()->back()->with('success', 'Attendance log cleared successfully!');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
}
