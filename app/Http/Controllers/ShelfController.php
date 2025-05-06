<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AnimeBookmark;

class ShelfController extends Controller
{
    public function wishlist()
    {
        $bookmarks = AnimeBookmark::where('user_id', Auth::id())
            ->where('status', 'wishlist')
            ->get();
        return view('home.anime.wishlist-page.wishlist', compact('bookmarks'));
    }

    public function finished()
    {
        $bookmarks = AnimeBookmark::where('user_id', Auth::id())
            ->where('status', 'finished')
            ->get();
        return view('home.anime.finish-page.finish', compact('bookmarks'));
    }

    public function favorite()
    {
        $bookmarks = AnimeBookmark::where('user_id', Auth::id())
            ->where('is_favorite', 1) // gunakan 1, bukan true
            ->get();
        return view('home.anime.fav-page.favorite', compact('bookmarks'));
    }
}
