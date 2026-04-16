<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\InOut;
use App\Models\ZktecoDevices;
use Illuminate\Console\Command;
use App\Repositories\Contracts\ZktecoConnectInterface as ZktDevice;
// use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(ZktDevice $zktDevice)
    {
        $apiUrl = "https://bsderp.test/api";
        $devices = ZktecoDevices::latest()->get();
        foreach ($devices as $device) {
            // $zk = $zktDevice->connectDevice($device->id);
            // $attendanceRecords = $zk->getAttendance();
            $attendanceRecords = Attendance::where('device_id', $device->id)->get();


            if (count($attendanceRecords) > 0) {
                // foreach ($attendanceRecords as $record) {
                // $timestamp = $record->timestamp;
                // $timestamp_date = Carbon::parse($timestamp)->format('Y-m-d');
                // $string = substr($zk->serialNumber(), strpos($zk->serialNumber(), "=") + 1);
                // $serialNumber = preg_replace('/null|\0/i', '', $string);

                // $response = Http::post($apiUrl . "/insertAttendance", [
                //     'employee_id' => 0,
                //     'clock_in' => 0,
                //     'clock_out' => 0,
                //     'status' => json_encode($attendanceRecords),
                //     'date' => 0
                // ]);

                $response = Http::post($apiUrl . "/insertAttendance", [
                    'attendanceData' => json_encode($attendanceRecords)
                ]);


                if ($response['success'] == true) {
                    // Attendance::where('device_id', $device->id)
                    //     ->where('user_id', $record->user_id)
                    //     ->where('timestamp', $record->timestamp)
                    //     ->delete();
                }
                Log::info($response);
                // }
            }
        }

        echo "sucessfully synced attendance";
    }
}
