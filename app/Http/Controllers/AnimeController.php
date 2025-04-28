<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\AnimeBookmark;
use Illuminate\Support\Facades\Auth;

class AnimeController extends Controller
{
    public function searchAnime(Request $request)
    {
        $query = $request->query('query');

        if (!$query) {
            return response()->json(['error' => 'Query parameter is required'], 400);
        }

        $response = Http::get("https://api.jikan.moe/v4/anime", [
            'q' => $query,
            'limit' => 10,
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch data from Jikan API'], 500);
        }

        return response()->json($response->json()['data']);
    }

    public function addBookmark(Request $request)
    {
        $user = auth()->user();
        $animeId = $request->input('anime_id');

        // Periksa apakah anime sudah dibookmark
        $existingBookmark = $user->animeBookmarks()->where('anime_id', $animeId)->first();

        if ($existingBookmark) {
            return response()->json([
                'message' => 'Anime is already bookmarked.',
                'status' => 'exists',
            ], 200);
        }

        // Simpan bookmark baru
        $user->animeBookmarks()->create([
            'anime_id' => $animeId,
            'title' => $request->input('title'),
            'image_url' => $request->input('image_url'),
            'status' => 'wishlist',
        ]);

        return response()->json([
            'message' => 'Anime added to bookmarks.',
            'status' => 'success',
        ], 201);
    }

    public function updateBookmarkStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:wishlist,finished',
        ]);

        $bookmark = AnimeBookmark::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $bookmark->update(['status' => $request->status]);

        return response()->json(['message' => 'Bookmark status updated successfully', 'bookmark' => $bookmark]);
    }

    public function getRandomAnime()
    {
        try {
            // Ambil data anime populer dari Jikan API
            $response = Http::get('https://api.jikan.moe/v4/top/anime');
            if ($response->failed()) {
                return response()->json(['error' => 'Failed to fetch data from Jikan API'], 500);
            }

            $animeList = $response->json()['data'];

            // Acak urutan anime dan ambil 8 anime secara acak
            $randomAnime = collect($animeList)->shuffle()->take(8);

            return response()->json($randomAnime);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching random anime'], 500);
        }
    }

    public function getUserBookmarks()
    {
        $bookmarks = AnimeBookmark::where('user_id', Auth::id())->get();

        return response()->json(['bookmarks' => $bookmarks]);
    }

    public function checkBookmarkStatus($anime_id)
    {
        $user = auth()->user();
        $isBookmarked = $user->animeBookmarks()->where('anime_id', $anime_id)->exists();

        return response()->json(['isBookmarked' => $isBookmarked]);
    }
}
