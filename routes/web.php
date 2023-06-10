<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [UserController::class, 'index']);

Route::middleware('auth')->group(function () {
    // FOLLOW AKUN
    Route::post('/follow/{id}', [UserController::class, 'follow'])->middleware('auth');

    // POSTINGAN
    Route::get('/my-profile', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::delete('my-profile/posts/{id}    ', [PostController::class, 'destroy']);

    // PROFILE EDIT
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
