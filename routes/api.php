<?php

use App\Http\Controllers\Admin\Web\CategoryController;
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

Route::get('category', [CategoryController::class, 'indexApi'])->name('test');

Route::post('category/create', [CategoryController::class, 'store'])->name('api.create');

Route::get('category/edit/{id}', [CategoryController::class, 'editApi'])->name('api.edit');

Route::put('category/edit/{id}', [CategoryController::class, 'update'])->name('api.update');

Route::delete('category/delete/{id}', [CategoryController::class, 'delete'])->name('api.delete');


