<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Web\CategoryController;
use App\Http\Controllers\Admin\Web\NoticeController;
use App\Http\Controllers\Admin\Web\PostController;
use App\Http\Controllers\Author\PostController as AuthorPostController;
use App\Http\Controllers\User\Auth\Authcontroller as AuthAuthcontroller;
use App\Http\Controllers\User\Web\CategoryController as WebCategoryController;
use App\Http\Controllers\User\Web\PostController as WebPostController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('admin')->name('admin.')
    ->middleware(['auth:admins',
        config('jetstream.auth_session'),
        'verified',
        ])
    ->group(function(){
        Route::prefix('category')->name('category.')->group(function(){
            Route::get('', [CategoryController::class, 'indexApi'])->name('api.list');

            Route::post('create', [CategoryController::class, 'store'])->name('api.create');

            Route::get('edit/{id}', [CategoryController::class, 'editApi'])->name('api.edit');

            Route::put('edit/{id}', [CategoryController::class, 'update'])->name('api.update');

            Route::delete('delete/{id}', [CategoryController::class, 'delete'])->name('api.delete');
        });

        Route::prefix('post')->name('post.')->group(function(){
            Route::get('', [PostController::class, 'indexApi'])->name('api.list');

            Route::post('create', [PostController::class, 'store'])->name('api.create');

            Route::put('edit/{id}', [PostController::class, 'update'])->name('api.update');

            Route::delete('delete/{id}', [PostController::class, 'delete'])->name('api.delete');
        });

        Route::prefix('notices')->name('notice.')->group(function(){
            Route::get('', [NoticeController::class, 'indexApi'])->name('api.lists');

            Route::post('create', [NoticeController::class, 'store'])->name('api.create');

            Route::put('edit/{id}', [NoticeController::class, 'editing'])->name('api.update');

            Route::delete('delete/{id}', [NoticeController::class, 'delete'])->name('api.delete');

            Route::get('send/{id}', [NoticeController::class, 'sendNotifications'])->name('api.send');
        });
});

Route::prefix('author')->name('author.')
    ->middleware(['auth:admins',
        config('jetstream.auth_session'),
        'verified',
        ])
    ->group(function(){
        Route::prefix('post')->name('post.')->group(function(){
            Route::get('', [AuthorPostController::class, 'indexApi'])->name('api.list');

            Route::post('create', [AuthorPostController::class, 'store'])->name('api.create');

            Route::put('edit/{id}', [AuthorPostController::class, 'update'])->name('api.update');

            Route::delete('delete/{id}', [AuthorPostController::class, 'delete'])->name('api.delete');
        });
});



Route::prefix('auth')->group(function(){

    Route::post('admin/login', [AuthController::class, 'handelLogin'])->name('api.handelLogin');

    Route::post('user/login', [AuthAuthcontroller::class, 'handelLogin'])->name('api.user.handelLogin');

});

Route::prefix('api.home')->name('home.api.')->group(function(){

    Route::get('categories', [WebPostController::class, 'categories'])->name('categories');

    Route::get('authors', [WebPostController::class, 'authors'])->name('authors');

    Route::get('tags', [WebPostController::class, 'tags'])->name('tags');

});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->name('api.')->group(function(){
    Route::get('like/{id}', [WebPostController::class, 'like'])->name('like');

    Route::post('comment/{id}', [WebPostController::class, 'comment'])->name('comment');

    Route::get('notification/{id}', [NotificationController::class, 'show'])->name('notification.show');
});



