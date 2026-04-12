<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;



Route::get('/', [AttendanceController::class, 'getUsers']);
Route::post("/adduser", [AttendanceController::class, 'addUser'])->name('adduser');
Route::patch("/EditUser", [AttendanceController::class, 'EditUser'])->name('edituser');
Route::delete("/deleteUser/{uid}", [AttendanceController::class, 'deleteUser']);
Route::get('/post_attendance', [AttendanceController::class, 'index']);
// Route::get('/addUser', [AttendanceController::class, 'addUser']);
