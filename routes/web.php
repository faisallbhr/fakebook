<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

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
    // AKTIFITAS
    // FOLLOW
    Route::get('followers/', [UserController::class, 'readFollowers']);
    Route::post('/follow/{id}', [UserController::class, 'follow']);
    Route::delete('unfollow/{id}', [UserController::class, 'unfollow']);
    Route::delete('delete-follower/{id}', [UserController::class, 'deleteFollower']);

    Route::post('/like/{id}', [UserController::class, 'like']);
    Route::post('/comment/{id}', [UserController::class, 'comment']);
    Route::delete('/comment/{id}', [UserController::class, 'uncomment']);

    // POSTINGAN
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/my-profile', [PostController::class, 'index']);
    Route::put('my-profile/posts/{id}', [PostController::class, 'update']);
    Route::delete('my-profile/posts/{id}', [PostController::class, 'destroy']);

    // PROFILE EDIT
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
