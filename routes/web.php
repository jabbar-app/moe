<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\Admin\AttendanceListController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/checkin/{token}', [CheckinController::class, 'show'])->name('checkin.show');
Route::post('/checkin/{token}', [CheckinController::class, 'store'])->name('checkin.store');
Route::get('/checkin/status/success', [CheckinController::class, 'success'])->name('checkin.success');
Route::get('/checkin/status/invalid', [CheckinController::class, 'invalid'])->name('checkin.invalid'); // Tambahan

Route::middleware('auth')->get('/dashboard', function () {
    return redirect()->route('admin.attendance-lists.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('attendance-lists', AttendanceListController::class);
        Route::patch('attendance-lists/{attendance_list}/regenerate-link', [AttendanceListController::class, 'regenerateLink'])->name('attendance-lists.regenerate-link');
    });
});

require __DIR__ . '/auth.php';
