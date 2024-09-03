<?php

use App\Http\Controllers\admin\DashController;
use App\Http\Controllers\admin\PermissionsController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\admin\PostController as AdminPostController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;

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
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');

Route::post('/comments/reply', [CommentController::class, 'storeReply'])->name('comment.store.reply');
Route::post('/notifications', [NotificationController::class, 'getNotifications']);
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('/user/{id}', [UserController::class, 'getPostsByUser'])->name('profile');
Route::get('/user/{id}/comments', [UserController::class, 'getCommentsByUser'])->name('user_comments');


Route::get('admin/dashboard', [DashController::class, 'index'])->name('admin.dashboard');
Route::resource('admin/category', CategoryController::class);
Route::resource('admin/posts', AdminPostController::class);
Route::resource('admin/roles', RoleController::class);
Route::get('admin/permission', [PermissionsController::class, 'index'])->name('permissions');
Route::post('admin/permission', [PermissionsController::class, 'store'])->name('permissions');
Route::get('permission/byRole', [RoleController::class, 'getbyRole'])->name('permission_byRole');

Route::resource('admin/user', UserController::class);
Route::resource('admin/pages', PageController::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
