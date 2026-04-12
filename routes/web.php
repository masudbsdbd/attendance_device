<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DeviceController;
use Illuminate\Support\Facades\Route;



Route::get('/', [AttendanceController::class, 'getUsers'])->name('users');
Route::post("/adduser", [AttendanceController::class, 'addUser'])->name('adduser');
Route::patch("/EditUser", [AttendanceController::class, 'EditUser'])->name('edituser');
Route::delete("/deleteUser/{uid}", [AttendanceController::class, 'deleteUser']);
Route::get('/post_attendance', [AttendanceController::class, 'index']);
// Route::get('/addUser', [AttendanceController::class, 'addUser']);
Route::get('/device', [DeviceController::class, 'deviceInfo']);
Route::post('/device/test-sound', [DeviceController::class, 'testSound']);
Route::post('/device/restart', [DeviceController::class, 'restartDevice']);
Route::post('/device/shutdown', [DeviceController::class, 'shutdownDevice']);
