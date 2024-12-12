<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('test', function () {
    return response()->json(['message' => 'Hello World!']);
});
