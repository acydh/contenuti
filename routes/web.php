<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Views\ArticleController;

Route::middleware(['auth'])->group(
    function () {
        Route::post('articles', [ArticleController::class, 'store']);
        Route::get('articles/create', [ArticleController::class, 'create']);
        Route::get('articles/{article}/edit', [ArticleController::class, 'edit']);
        Route::patch('articles/{article}', [ArticleController::class, 'update']);
    }
);

Route::middleware(['auth.optional'])->group(
    function () {
        Route::get('/', [ArticleController::class, 'index']);
        Route::get('articles/{article}', [ArticleController::class, 'show']);
    }
);

require __DIR__ . '/auth.php';
