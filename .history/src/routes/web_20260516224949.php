<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkingController;
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

Route::middleware('auth')->group(function () {
    Route::get('/', [WorkingController::class, 'index']);
});

Route::get('/attendance/detail/', [WorkingController::class, 'detail'])->name('detail.index');
Route::get('/attendance', [WorkingController::class, 'apply']);

Route::get('/admin', [AdminWorkingController::class, 'index']);
Route::get('/admin/attendance/', [AdminWorkingController::class, 'detail'])->name('admin_detail.index');
