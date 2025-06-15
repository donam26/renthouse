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
        return redirect()->route('houses.by.username', ['username' => auth()->user()->username]);
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

    // Routes cho quản lý media
    Route::get('/media', [App\Http\Controllers\UserMediaController::class, 'index'])->name('media.index');
    Route::get('/media/create', [App\Http\Controllers\UserMediaController::class, 'create'])->name('media.create');
    Route::post('/media', [App\Http\Controllers\UserMediaController::class, 'store'])->name('media.store');
    Route::get('/media/{media}/edit', [App\Http\Controllers\UserMediaController::class, 'edit'])->name('media.edit');
    Route::put('/media/{media}', [App\Http\Controllers\UserMediaController::class, 'update'])->name('media.update');
    Route::delete('/media/{media}', [App\Http\Controllers\UserMediaController::class, 'destroy'])->name('media.destroy');
    Route::post('/media/update-order', [App\Http\Controllers\UserMediaController::class, 'updateOrder'])->name('media.update-order');
});

// Tải các route admin từ file admin.php
require __DIR__.'/admin.php';

require __DIR__.'/auth.php';

// Route cho truy cập thông qua share_link - không cần đăng nhập
Route::get('/share/{shareLink}', [HouseController::class, 'showByShareLink'])
    ->name('houses.share');

// Route cho hiển thị danh sách nhà theo username - đặt ở cuối để tránh xung đột
Route::get('/{username}', [HouseController::class, 'showByUsername'])
    ->middleware(['auth'])
    ->name('houses.by.username');

// Chia sẻ kết quả tìm kiếm nhà
Route::get('/houses/shared/search', [App\Http\Controllers\HouseController::class, 'sharedSearch'])->name('houses.shared.search');
