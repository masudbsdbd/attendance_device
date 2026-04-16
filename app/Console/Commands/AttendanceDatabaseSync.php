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
use App\Repositories\Contracts\ZktecoAttendanceInterface as ZktAttendance;

class AttendanceDatabaseSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(ZktDevice $zktDevice, ZktAttendance $zktAttendance)
    {
        // $apiUrl = "https://bsderp.test/api";
        $devices = ZktecoDevices::latest()->get();
        foreach ($devices as $device) {
            $zk = $zktDevice->connectDevice($device->id);
            $attendanceRecords = $zk->getAttendance();
            Log::info($attendanceRecords);
            if (count($attendanceRecords) > 0) {
                foreach ($attendanceRecords as $record) {
                    $timestamp = $record['timestamp'];
                    $timestamp_date = Carbon::parse($timestamp)->format('Y-m-d');
                    $string = substr($zk->serialNumber(), strpos($zk->serialNumber(), "=") + 1);
                    $serialNumber = preg_replace('/null|\0/i', '', $string);

                    $exists = Attendance::where('uid', $record['uid'])
                        ->where('user_id', $record['id'])
                        ->where('timestamp', $timestamp)
                        ->exists();

                    if (!$exists) {
                        Attendance::create([
                            'uid' => $record['uid'],
                            'device_id' => $device->id,
                            'user_id' => $record['id'],
                            'state' => $record['state'],
                            'timestamp' => $timestamp,
                            'type' => $record['type'],
                        ]);
                    }
                }

                // $zktAttendance->clearAttendanceLog($zktDevice, $device->id);
            }
        }

        echo "Syncing attendance database...";
    }
}
