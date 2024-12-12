<?php

use App\Http\Controllers\Api\V1\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\SearchController;

Route::get('search', [SearchController::class, 'search']);

Route::get('/posts', [PostController::class, 'index']);
