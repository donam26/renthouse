<?php

use App\Http\Controllers\HouseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route mặc định
Route::get('/', function () {
    // Nếu đã đăng nhập, chuyển đến trang quản lý nhà
    if (Auth::check()) {
        return redirect()->route('houses.index');
    }
    // Nếu chưa đăng nhập, hiển thị trang welcome
    return view('welcome');
});


// Route cho người dùng đã đăng nhập
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Resource routes cho quản lý nhà
    Route::resource('houses', HouseController::class);
});

// Tải các route admin từ file admin.php
require __DIR__.'/admin.php';

require __DIR__.'/auth.php';

// Route cho hiển thị danh sách nhà theo username - đặt ở cuối để tránh xung đột
Route::get('/{username}', [HouseController::class, 'showByUsername'])
    ->middleware(['auth'])
    ->name('houses.by.username');

// Chia sẻ kết quả tìm kiếm nhà
Route::get('/houses/shared/search', [App\Http\Controllers\HouseController::class, 'sharedSearch'])->name('houses.shared.search');
