<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkingController;
use App\Http\Controllers\ApplyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminApplyController;
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
    Route::match(['get', 'post'], '/admin/attendance/list', [AdminWorkingController::class, 'index'])->name('admin_attendance.index');
    //Route::post('/admin/attendance/list', [AdminWorkingController::class, 'index'])->name('admin_attendance.index');
    Route::get('/admin/attendance/{id}', [AdminWorkingController::class, 'detail'])->name('admin_detail.index');
    Route::get('/admin/staff/list', [AdminWorkingController::class, 'staff'])->name('admin_staff.index');
    Route::match(['get', 'post'], '/admin/attendance/staff/{id}', [AdminWorkingController::class, 'person'])->name('person.index');

    Route::get('/stamp_correction_request/list/wait', [AdminApplyController::class, 'wait'])->name('admin_wait.index');
    Route::get('/stamp_correction_request/list/approved', [AdminApplyController::class, 'approved'])->name('admin_approved.index');
    Route::get('/stamp_correction_request/list/approve/{attendance_correct_request_id}', [AdminApplyController::class, 'request'])->name('request.index');
    Route::post('/stamp_correction_request/list/approve', [AdminApplyController::class, 'approval'])->name('approval.update');
    
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/attendance', [WorkingController::class, 'index']);
    Route::post('/working/start', [WorkingController::class, 'working__start']);
    Route::post('/working/end', [WorkingController::class, 'working__end']);
    Route::post('/break/start', [WorkingController::class, 'break__start']);
    Route::post('/break/end', [WorkingController::class, 'break__end']);
    Route::match(['get', 'post'], '/attendance/list', [WorkingController::class, 'attendance'])->name('attendance.index');
    //Route::post('/attendance/list', [WorkingController::class, 'attendance'])->name('attendance.index');

    Route::get('/attendance/detail/{id}', [ApplyController::class, 'detail'])->name('detail.index');
    Route::post('/attendance/request/{id}', [ApplyController::class, 'request'])->name('detail.update');
    Route::match(['get', 'post'], '/stamp_correction_request/list', [ApplyController::class, 'apply'])->name('apply.index');
    Route::get('/stamp_correction_request/list/apply', [ApplyController::class, 'show'])->name('show.index');
});

