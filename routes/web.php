<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\ShelfController;
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
Route::patch('/anime/bookmark/{id}/favorite', [AnimeController::class, 'toggleFavorite'])->name('anime.toggleFavorite');
Route::patch('/anime/bookmark/{id}/finished', [AnimeController::class, 'toggleFinished'])->name('anime.toggleFinished');
Route::delete('/anime/bookmark/{id}', [AnimeController::class, 'deleteBookmark'])->name('anime.deleteBookmark');

// Route for random anime recommendation
Route::get('/random-anime', [AnimeController::class, 'getRandomAnime'])->name('random-anime');

// Route to check if an anime is already bookmarked
Route::get('/anime/bookmark-status/{anime_id}', [AnimeController::class, 'checkBookmarkStatus'])->name('anime.bookmarkStatus');

// Route for anime detail page
Route::get('/anime/detail/{id}', [AnimeController::class, 'showDetail'])->name('anime.detail');

// Protected routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('home.home'); // Ensure this route points to the home view
    });

    Route::get('/anime/bookmarks', [AnimeController::class, 'getUserBookmarks'])->name('anime.userBookmarks');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('home.profile.profile');
    })->name('profile');

    Route::patch('/profile', [AppileController::class, 'update'])->name('profile.update');
});

// Route for anime shelf
Route::get('/anime/shelf', function () {
    return view('home.anime.shelf');
})->name('anime.shelf');

// Routes for shelf categories (wishlist, finished, favorite) - gunakan controller
Route::middleware('auth')->group(function () {
    Route::get('/anime/shelf/wishlist', [ShelfController::class, 'wishlist'])->name('anime.shelf.wishlist');
    Route::get('/anime/shelf/finished', [ShelfController::class, 'finished'])->name('anime.shelf.finished');
    Route::get('/anime/shelf/favorite', [ShelfController::class, 'favorite'])->name('anime.shelf.favorite');
});

// Default route
Route::middleware('auth')->get('/', function () {
    return view('home.home'); // Pastikan ini adalah halaman yang benar
})->name('home');
