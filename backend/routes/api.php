<?php

use App\Http\Controllers\API\BloggerAuthController;
use App\Http\Controllers\API\BloggerProfileController;
use App\Http\Controllers\API\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register', [BloggerAuthController::class, 'register']);
Route::post('/login', [BloggerAuthController::class, 'login']);

Route::prefix('/posts')->group(function () {
    Route::get('/', [PostController::class, 'getAllActivePost']);
    Route::get('/{slug}', [PostController::class, 'getDetailPostBySlug']);
});

Route::prefix('/blogger')->group(function () {
    Route::get('/{slug}', [BloggerProfileController::class, 'getPublicProfileInfor']);
});

Route::middleware(['auth:blogger'])->group(function () {
    Route::delete('/logout', [BloggerAuthController::class, 'logout']);

    Route::prefix('/blogger')->group(function () {
        Route::get('/me/profile', [BloggerProfileController::class, 'getMyProfileInfor']);
    });
    
    Route::prefix('/posts')->group(function () {
        Route::post('/create-post', [PostController::class, 'store']);
    });

    
});
