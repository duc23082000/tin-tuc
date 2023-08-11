<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Web\AuthorController;
use App\Http\Controllers\Admin\Web\PostController;
use App\Http\Controllers\Client\HomeController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

Route::get('delete-acc', function () {
    User::find(request()->user()->id)->delete();
    return redirect(route('login'));
})->name('delete.acc');

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::prefix('auth')->group(function(){
    Route::middleware('auth.check')->group(function(){
        Route::get('login', [AuthController::class, 'login'])->name('login');

        Route::post('login', [AuthController::class, 'handelLogin']);

        Route::get('register', [AuthController::class, 'register'])->name('register');

        Route::post('register', [AuthController::class, 'handelRegister']);

        Route::get('forgot-password', [AuthController::class, 'forgot'])->name('forgot');

        Route::post('forgot-password', [AuthController::class, 'sendMailReset']);

        Route::get('login/google', [AuthController::class, 'redirectToGoogle'])->name('login.Google');

        Route::get('login/google/callback', [AuthController::class, 'handleGoogleCallback']);
    });

    Route::get('reset-password/email={email}&token={token}', [AuthController::class, 'reset'])->name('password.reset');

    Route::post('reset-password/email={email}&token={token}', [AuthController::class, 'reseting']);


});

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'auth.admin'])->group(function(){
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

    Route::get('change-password', [AuthController::class, 'formChange'])->name('change');

    Route::post('change-password', [AuthController::class, 'changePassword']);

    Route::get('/email/verification-notification', [AuthController::class, 'sendMailVerify'])->middleware('throttle:6,1')->name('verification.send');

    Route::prefix('authors')->name('author.')->group(function(){
        Route::get('', [AuthorController::class, 'index'])->name('lists');

        Route::get('create', [AuthorController::class, 'create'])->name('create');

        Route::post('create', [AuthorController::class, 'creating']);

        Route::get('edit/{id}', [AuthorController::class, 'edit'])->name('edit');

        Route::put('edit/{id}', [AuthorController::class, 'editing']);

        Route::get('delete/{id}', [AuthorController::class, 'delete'])->name('delete');

    });

    Route::prefix('posts')->name('post.')->group(function(){
        Route::get('', [PostController::class, 'index'])->name('lists');

        Route::get('create', [PostController::class, 'create'])->name('create');

        Route::post('create', [PostController::class, 'creating']);

        Route::get('edit/{id}', [PostController::class, 'edit'])->name('edit');

        Route::put('edit/{id}', [PostController::class, 'editing']);

        Route::get('delete/{id}', [PostController::class, 'delete'])->name('delete');
    });


});


