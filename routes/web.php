<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('/get-users/{device_id}', [UserController::class, 'getUsers'])->name('users');
Route::post("/adduser/{device_id}", [UserController::class, 'addUser'])->name('adduser');
Route::patch("/EditUser/{device_id}", [UserController::class, 'EditUser'])->name('edituser');
Route::delete("/deleteUser/{uid}/{device_id}", [UserController::class, 'deleteUser'])->name('deleteuser');

// Route::get('/addUser', [AttendanceController::class, 'addUser']);

// crud device
Route::get('/', [DeviceController::class, 'index']);
Route::post('/devices', [DeviceController::class, 'store']);
Route::delete('/devices/{id}', [DeviceController::class, 'destroy']);
Route::get('/device-info/{device_id}', [DeviceController::class, 'deviceInfo'])->name("device-info");
Route::post('/device/test-sound/{device_id}', [DeviceController::class, 'testSound'])->name("test-sound");
Route::post('/device/restart/{device_id}', [DeviceController::class, 'restartDevice'])->name("restart-device");
Route::post('/device/shutdown/{device_id}', [DeviceController::class, 'shutdownDevice'])->name("shutdown-device");


Route::get('/post_attendance', [AttendanceController::class, 'index']);
Route::get('/attendance-log/{device_id}', [AttendanceController::class, 'attendanceLog'])->name("attendance-log");
Route::delete('/clear-attendance-log/{device_id}', [AttendanceController::class, 'clearAttendanceLog'])->name("clear-attendance-log");
