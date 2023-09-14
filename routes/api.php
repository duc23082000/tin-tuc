<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Web\CategoryController;
use App\Http\Controllers\Admin\Web\PostController;
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

Route::prefix('admin')->name('admin.')->middleware(['auth:admins',
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

        Route::put('edit/{id}', [CategoryController::class, 'update'])->name('api.update');

        Route::delete('delete/{id}', [CategoryController::class, 'delete'])->name('api.delete');
    });
});



Route::prefix('auth')->group(function(){

    Route::post('admin/login', [AuthController::class, 'handelLogin'])->name('api.handelLogin');

});



