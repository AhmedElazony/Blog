<?php

use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])
    ->name('home');

Route::post('/newsletter', NewsletterController::class);

Route::get('/posts/{post:slug}', [PostController::class, 'show'])
    ->name('posts.show');

Route::post('/posts/{post:slug}/comments', [PostCommentController::class, 'store'])
    ->name('post-comment.store');

Route::get('/register', [RegisterController::class, 'create'])
    ->name('register.create')->middleware('guest');

Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store')->middleware('guest');

Route::get('/login', [SessionsController::class, 'create'])
    ->name('sessions.create')->middleware('guest');

Route::post('/login', [SessionsController::class, 'store'])
    ->name('sessions.store')->middleware('guest');

Route::delete('/logout', [SessionsController::class, 'destroy'])
    ->name('sessions.destroy')->middleware('auth');

Route::get('admin/posts', [AdminPostController::class, 'index'])
    ->middleware('admin')->name('admin.posts');

Route::get('/admin/posts/create' , [AdminPostcontroller::class, 'create'])
    ->name('post.create')->middleware('admin');

Route::post('/admin/posts', [AdminPostController::class, 'store'])
    ->middleware('admin')->name('admin-post.store');

Route::get('/admin/posts/{post}/edit', [AdminPostController::class, 'edit'])
    ->middleware('admin')->name('admin-post.edit');

Route::patch('/admin/posts/{post}', [AdminPostController::class, 'update'])
    ->middleware('admin')->name('admin-post.update');

Route::delete('/admin/posts/{post}', [AdminPostController::class, 'destroy'])
    ->middleware('admin')->name('admin-post.destroy');

