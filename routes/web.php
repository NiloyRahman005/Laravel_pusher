<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/pusher1','pusher1');
Route::view('/pusher2','pusher2');
Route::get('/post', function () {
    return view('post');
});
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
