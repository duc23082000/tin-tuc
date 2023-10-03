<?php

use App\Http\Controllers\User\Auth\Authcontroller as AccAuthcontroller;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Web\AuthorController;
use App\Http\Controllers\Admin\Web\CategoryController;
use App\Http\Controllers\Admin\Web\NoticeController;
use App\Http\Controllers\Admin\Web\PostController;
use App\Http\Controllers\Admin\Web\TagController;
use App\Http\Controllers\Admin\Web\UserController;
use App\Http\Controllers\Author\NotificationController as AuthorNotificationController;
use App\Http\Controllers\Author\PostController as AuthorPostController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\User\Web\NotificationController;
use App\Http\Controllers\User\Web\PostController as WebPostController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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






Route::prefix('auth')->group(function(){
    Route::prefix('admin')->name('admin.')->group(function(){
        Route::get('login', [AuthController::class, 'login'])->name('login');

        Route::get('register', [AuthController::class, 'register'])->name('register');

        Route::post('register', [AuthController::class, 'handelRegister']);

        Route::get('forgot-password', [AuthController::class, 'forgot'])->name('forgot');

        Route::post('forgot-password', [AuthController::class, 'sendMailReset']);

    });

    Route::prefix('account')->name('account.')->group(function(){
        Route::get('login', [AccAuthcontroller::class, 'login'])->name('login');

        Route::post('login', [AccAuthcontroller::class, 'handelLogin']);

        Route::get('register', [AccAuthcontroller::class, 'register'])->name('register');

        Route::post('register', [AccAuthcontroller::class, 'handelRegister']);

        Route::get('forgot-password', [AccAuthcontroller::class, 'forgot'])->name('forgot');

        Route::post('forgot-password', [AccAuthcontroller::class, 'sendMailReset']);

        Route::get('login/google', [AccAuthcontroller::class, 'redirectToGoogle'])->name('login.Google');

        Route::get('login/google/callback', [AccAuthcontroller::class, 'handleGoogleCallback']);
    });

    Route::get('reset-password/email={email}&token={token}', [AccAuthcontroller::class, 'reset'])->name('password.reset');

    Route::post('reset-password/email={email}&token={token}', [AccAuthcontroller::class, 'reseting']);


});

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');

Route::prefix('admin')->name('admin.')->middleware(['auth:admins', 'delete.imageCkeditor'])->group(function(){
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('authors')->name('author.')->group(function(){
        Route::get('', [AuthorController::class, 'index'])->name('lists');

        Route::get('create', [AuthorController::class, 'create'])->name('create');

        Route::get('edit/{id}', [AuthorController::class, 'edit'])->name('edit');
    });

    Route::prefix('users')->name('user.')->group(function(){
        Route::get('', [UserController::class, 'index'])->name('lists');

        Route::get('create', [UserController::class, 'create'])->name('create');

        Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
    });

    Route::prefix('posts')->name('post.')->group(function(){
        Route::get('', [PostController::class, 'index'])->name('lists');

        Route::withoutMiddleware('delete.imageCkeditor')->group(function(){
            Route::get('create', [PostController::class, 'create'])->name('create');
            
            Route::post('upload', [PostController::class, 'upload'])->name('upload');

            Route::get('edit/{id}', [PostController::class, 'edit'])->name('edit');

            Route::put('edit/{id}', [PostController::class, 'editing']);
        });
    });

    Route::prefix('categories')->name('category.')->group(function(){
        Route::get('', [CategoryController::class, 'index'])->name('lists');

        Route::get('create', [CategoryController::class, 'create'])->name('create');

        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
    });

    Route::prefix('notices')->name('notice.')->group(function(){
        Route::get('', [NoticeController::class, 'index'])->name('lists');

        Route::get('create', [NoticeController::class, 'create'])->name('create');

        Route::get('edit/{id}', [NoticeController::class, 'edit'])->name('edit');

        Route::get('send/{id}', [NoticeController::class, 'sendNotifications'])->name('send');

    });


});

Route::prefix('')->name('user.')->middleware('auth')->group(function(){
    Route::get('logout', [AccAuthcontroller::class, 'logout'])->name('logout');

    Route::get('change-password', [AccAuthcontroller::class, 'formChange'])->name('change');

    Route::post('change-password', [AccAuthcontroller::class, 'changePassword']);
});

Route::prefix('author')->name('author.')->middleware(['auth:admins', 'delete.imageCkeditor'])->group(function(){

    Route::prefix('posts')->name('post.')->group(function(){
        Route::get('', [AuthorPostController::class, 'index'])->name('lists');

        Route::withoutMiddleware('delete.imageCkeditor')->group(function(){
            Route::get('create', [AuthorPostController::class, 'create'])->name('create');

            Route::post('create', [AuthorPostController::class, 'creating']);
    
            Route::post('upload', [AuthorPostController::class, 'upload'])->name('upload');
    
            Route::get('edit/{id}', [AuthorPostController::class, 'edit'])->name('edit');
    
            Route::put('edit/{id}', [AuthorPostController::class, 'editing']);
        });

        Route::get('delete/{id}', [AuthorPostController::class, 'delete'])->name('delete');
    });

});

Route::get('auth', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});



Route::get('category', [WebPostController::class, 'index'])->name('home.category');

Route::get('search', [WebPostController::class, 'index'])->name('home.search');

Route::get('author', [WebPostController::class, 'index'])->name('home.author');

Route::get('tag', [WebPostController::class, 'index'])->name('home.tag');

Route::get('{title}', [WebPostController::class, 'show'])->name('home.show');

Route::get('', [WebPostController::class, 'index'])->name('home');

Route::get('notification/{id}', [NotificationController::class, 'show'])->middleware('auth')->name('notification.show');







