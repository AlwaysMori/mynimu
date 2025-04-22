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
        $request->validate([
            'anime_id' => 'required|string',
            'title' => 'required|string',
            'image_url' => 'required|url',
        ]);

        $bookmark = AnimeBookmark::create([
            'user_id' => Auth::id(),
            'anime_id' => $request->anime_id,
            'title' => $request->title,
            'image_url' => $request->image_url,
        ]);

        return response()->json(['message' => 'Bookmark added successfully', 'bookmark' => $bookmark], 201);
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
}
