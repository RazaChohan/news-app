<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Auth routes
 */

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function() {
    /**E
     * News routes
     */
    Route::get('news', [NewsController::class, 'index'])->name('news-list');
    Route::get('news/{news}', [NewsController::class, 'show'])->name('news-get');
    Route::post('news', [NewsController::class, 'store'])->name('news-create');
    Route::put('news/{news}', [NewsController::class, 'update'])->name('news-update');
    Route::delete('news/{news}', [NewsController::class, 'delete'])->name('news-delete');
});
