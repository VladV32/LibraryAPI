<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::middleware('auth:api')
    ->apiResource('books', BookController::class)
    ->only(
        [
            'index',
            'store',
            'show',
            'update',
            'destroy'
        ]
    );
