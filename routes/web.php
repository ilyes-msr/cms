<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PostController::class, 'index']);
Route::get('/category/{category_id}/{category_slug}', [PostController::class, 'posts_by_category'])->name('posts_by_category');
Route::resource('/post', PostController::class);
Route::post('/search', [PostController::class, 'search'])->name('search');

Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');

Route::post('/comments/reply', [CommentController::class, 'storeReply'])->name('comment.store.reply');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
