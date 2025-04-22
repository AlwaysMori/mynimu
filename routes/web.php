<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AnimeController;

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Route for searching anime
Route::get('/search-anime', [AnimeController::class, 'searchAnime'])->name('search-anime');

// Route for managing anime bookmarks
Route::post('/anime/bookmark', [AnimeController::class, 'addBookmark'])->name('anime.bookmark');
Route::patch('/anime/bookmark/{id}', [AnimeController::class, 'updateBookmarkStatus'])->name('anime.updateBookmark');

// Protected routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('home.home'); // Ensure this route points to the home view
    });
});

// Default route
Route::get('/', function () {
    return redirect('/login');
});
