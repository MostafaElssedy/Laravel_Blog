<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BlogController;

// Front Routes
Route::controller(BlogController::class)->group(function() {
    Route::get('/', 'index')->name('home');
    Route::get('/articles', 'articles')->name('articles');
    Route::get('/categories', 'categories')->name('categories');
    Route::get('/about', 'about')->name('about');
    Route::get('/privacy-policy', 'privacy')->name('privacy');
    Route::get('/terms', 'terms')->name('terms');
    Route::get('/cookie-policy', 'cookies')->name('cookies');
    Route::get('/post/{slug}', 'show')->name('post.show');
    Route::get('/posts/category/{slug}', 'categoryPosts')->name('category.posts');
    Route::get('/posts/author/{username}', 'authorPosts')->name('author.posts');
    Route::get('/posts/tag/{any}', 'tagPosts')->name('tag.posts');
    Route::get('/authors', 'authors')->name('authors');
    Route::get('/search', 'search')->name('search');
    Route::get('/api/search', 'searchJson')->name('api.search');
    Route::get('/api/trending-topics', 'trendingTopics')->name('api.trending');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactProcess')->name('contactProcess');
});





// admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::get('login', 'login')->name('login');
            Route::post('login', 'loginProcess')->name('loginProcess');
            Route::get('forgot', 'forgot')->name('forgot');
            Route::post('forgot', 'sendPasswordResetLink')->name('sendPasswordResetLink');
            Route::get('reset-password/{token}', 'resetPassword')->name('resetPassword');
            Route::post('reset-password', 'resetPasswordProcess')->name('resetPasswordProcess');
        });
    });
    
    Route::middleware(['auth'])->group(function(){
        Route::controller(AdminController::class)->group(function(){
            Route::get('dashboard', 'dashboard')->name('dashboard');
            Route::get('profile', 'profile')->name('profile');
            Route::post('update-profile-picture', 'updateProfilePicture')->name('updateProfilePicture');
            Route::post('logout', 'logout')->name('logout');
            
            Route::middleware(['role:superAdmin'])->group(function() {
                Route::get('settings', 'settings')->name('settings');
                Route::get('categories', 'categories')->name('categories');
                Route::get('users', 'users')->name('users');
            });
        });

        Route::prefix('posts')->name('posts.')->controller(PostController::class)->group(function() {
            Route::get('all-posts', 'allPosts')->name('all-posts');
            Route::get('add-post', 'addPost')->name('add-post');
            Route::post('create', 'storePost')->name('store');
            Route::get('edit-post/{id}', 'editPost')->name('edit-post');
            Route::post('update-post/{id}', 'updatePost')->name('update-post');
            
        });
    });
});


