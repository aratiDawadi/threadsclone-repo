<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [HomeController::class, 'home']);
Route::get('login', [HomeController::class, 'index'])->name('login');
Route::get('dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
Route::get('register', [HomeController::class, 'register'])->name('register-user');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('postsignup', [UserController::class, 'signupsave'])->name('postsignup');


Route::post('postlogin', [LoginController::class, 'login'])->name('postlogin');
Route::get('forgot-password', [ForgotController::class, 'forgotPasswordLoad']);
Route::post('forgot-password', [ForgotController::class, 'forgotPassword'])->name('forgotPassword');

Route::get('reset/{token}', [ForgotController::class, 'resetPasswordLoad']);
Route::post('reset/{token}', [ForgotController::class, 'resetPassword'])->name('resetPassword');

Route::get('user-profile', [ProfileController::class, 'userProfileLoad'])->name('CreateProfile')->middleware('auth');
Route::post('user-profile', [ProfileController::class, 'userProfile'])->name('userProfile')->middleware('auth');

Route::get('edit-profile', [ProfileController::class, 'editProfile'])->name('editProfile')->middleware('auth');
Route::get('/profile/{user_id}', [ProfileController::class, 'showProfile'])->name('user.Profile'); // This route is for viewing the profile of a specific user


Route::get('search', [SearchController::class, 'SearchName'])->name('search');
Route::get('logout', [HomeController::class, 'logout'])->name('logout');

Route::get('/comment/{id}', [CommentController::class, 'show'])->name('comment');   // Route to show a specific content and its comments
Route::post('comment', [CommentController::class, 'store'])->name('comment-store');

Route::post('comment/{id}/reply', [CommentController::class, 'store'])->name('comment-reply');
Route::get('/reply/{id}/replies', [CommentController::class, 'showReplies'])->name('showReplies');

Route::patch('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::delete('/replies/{id}', [CommentController::class, 'remove'])->name('replies.destroy');
Route::patch('/replies/{id}', [CommentController::class, 'edit'])->name('replies.update');


Route::get('create-thread', [ContentController::class, 'CreateLoad'])->name('createPage');
Route::post('upload', [ContentController::class, 'showPost'])->name('showPost');
Route::delete('/delete-content/{id}', [ContentController::class, 'deleteContent'])->name('deleteContent');
Route::post('/edit-content/{id}', [ContentController::class, 'editContent'])->name('editContent');
// Route::get('/user/replies', [ProfileController::class, 'showUserReplies'])->name('user.replies');


Route::post('/like-content/{content}', [LikeController::class, 'like'])->name('content.like');

Route::post('/content/{content}/liked', [LikeController::class, 'likedStatus'])->name('auth');
