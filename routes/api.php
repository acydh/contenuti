<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use \App\Http\Controllers\AuthController;

// Auth routes

Route::middleware(['auth:sanctum'])->group(function () {

    // User

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // Articles

    Route::get('/articles', [ArticleController::class, 'index']); // Lists also the unplublished articles
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::get('/articles/{article}', [ArticleController::class, 'show']); // Shows also a unplublished article
    Route::patch('/articles/{article}', [ArticleController::class, 'update']);
});


// Guest routes

Route::post('/login', [AuthController::class, 'login']);

// Articles

Route::get('/guest/articles', [ArticleController::class, 'indexGuest']); // Lists the published articles only
Route::get('/guest/articles/{article}', [ArticleController::class, 'showGuest']); // Shows an article if published
