<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminWorkingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.showLogin');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');

Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('/admin/attendance/list', [AdminWorkingController::class, 'index'])->name('admin.index');
    
    Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/attendance', [WorkingController::class, 'index']);
    Route::post('/working/start', [WorkingController::class, 'working__start']);
    Route::post('/working/end', [WorkingController::class, 'working__end']);
    Route::post('/break/start', [WorkingController::class, 'break__start']);
    Route::post('/break/end', [WorkingController::class, 'break__end']);
    Route::get('/attendance/list', [WorkingController::class, 'attendance'])->name('attendance.index');
    Route::get('/attendance/detail/{id}', [WorkingController::class, 'detail'])->name('detail.index');
    Route::get('/attendance/request', [WorkingController::class, 'apply']);
});

Route::get('/admin/attendance/list', [AdminWorkingController::class, 'index'])->name('admin_attendance.index');
Route::get('/admin/attendance/', [AdminWorkingController::class, 'detail'])->name('admin_detail.index');
Route::get('/admin/staff/list', [AdminWorkingController::class, 'staff'])->name('admin_staff.index');
Route::get('/admin/attendance/staff/', [AdminWorkingController::class, 'person'])->name('person.index');
Route::get('/stamp_correction_request/list', [AdminWorkingController::class, 'apply'])->name('admin_apply.index');
Route::get('/stamp_correction_request/approve/', [AdminWorkingController::class, 'approval'])->name('approval.index');