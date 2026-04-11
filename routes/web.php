<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;



Route::get('/', [AttendanceController::class, 'getUsers']);
Route::post("/adduser", [AttendanceController::class, 'addUser'])->name('adduser');
Route::post("/EditUser", [AttendanceController::class, 'addUser'])->name('edituser');
Route::delete("/deleteUser/{uid}", [AttendanceController::class, 'deleteUser']);
Route::get('/post_attendance', [AttendanceController::class, 'index']);
// Route::get('/addUser', [AttendanceController::class, 'addUser']);
