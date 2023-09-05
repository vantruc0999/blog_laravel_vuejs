<?php

use App\Http\Controllers\API\BloggerAuthController;
use App\Http\Controllers\API\BloggerProfileController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\LikeController;
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
Route::get('/tags/get-all-tags', [PostController::class, 'getAllTags']);
Route::get('/categories/get-all-categories', [PostController::class, 'getAllCategories']);
Route::get('/bloggers', [BloggerProfileController::class, 'getAllBloggers']);
Route::get('/categories-tags',[PostController::class, 'getTagsCategories']);

Route::prefix('/posts')->group(function () {
    Route::get('/', [PostController::class, 'getAllActivePost']);
    Route::get('/{slug}', [PostController::class, 'getDetailPostById']);
});

Route::prefix('/blogger')->group(function () {
    Route::get('/{id}', [BloggerProfileController::class, 'getPublicProfileInfor']);
});

Route::middleware(['auth:blogger'])->group(function () {
    Route::delete('/logout', [BloggerAuthController::class, 'logout']);

    Route::prefix('/blogger')->group(function () {
        Route::get('/me/profile', [BloggerProfileController::class, 'getMyProfileInfor']);
        Route::post('/me/update-profile', [BloggerProfileController::class, 'updateBloggerProfile']);
        Route::post('/follow/{id}', [BloggerProfileController::class, 'follow']);
        Route::post('/check-follow/{id}', [BloggerProfileController::class, 'isFollowed']);
        // Route::delete('/unfollow/{id}', [BloggerProfileController::class, 'unfollow']);
    });
    
    Route::prefix('/posts')->group(function () {
        Route::post('/create-post', [PostController::class, 'store']);
        Route::post('/update-post/{slug}', [PostController::class, 'update']);
        Route::delete('/delete-post/{slug}', [PostController::class, 'delete']);
    });

    Route::prefix('/comment')->group(function () {
        Route::post('/{slug}', [CommentController::class, 'commentPost']);
        Route::post('/edit-comment/{id}', [CommentController::class, 'editComment']);
        Route::delete('/delete-comment/{id}', [CommentController::class, 'deleteComment']);
    });

    Route::prefix('/like')->group(function () {
        Route::post('/{id}', [LikeController::class, 'likePost']);
        Route::post('/check-like/{id}', [LikeController::class, 'checkLike']);
        Route::get('/get-liked-post', [LikeController::class, 'getAllLikedPosts']);
    });
    
});
