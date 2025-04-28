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

        // Check if anime already bookmarked
        $existingBookmark = $user->animeBookmarks()->where('anime_id', $animeId)->first();

        if ($existingBookmark) {
            return response()->json([
                'message' => 'Anime is already bookmarked.',
                'status' => 'exists',
            ], 200);
        }

        // Save new bookmark
        $user->animeBookmarks()->create([
            'anime_id' => $animeId,
            'title' => $request->input('title'),
            'image_url' => $request->input('image_url'),
            'status' => $request->input('status', 'wishlist'), // Default to wishlist if not provided
            'is_favorite' => $request->input('is_favorite', false),
            'is_finished' => $request->input('is_finished', false),
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

    public function toggleFavorite(Request $request, $id = null)
    {
        $bookmark = AnimeBookmark::firstOrCreate(
            ['anime_id' => $request->input('anime_id'), 'user_id' => Auth::id()],
            [
                'title' => $request->input('title'),
                'image_url' => $request->input('image_url'),
            ]
        );

        $bookmark->update(['is_favorite' => !$bookmark->is_favorite]);

        return response()->json(['message' => 'Favorite status toggled successfully', 'bookmark' => $bookmark]);
    }

    public function toggleFinished(Request $request, $id = null)
    {
        $bookmark = AnimeBookmark::firstOrCreate(
            ['anime_id' => $request->input('anime_id'), 'user_id' => Auth::id()],
            [
                'title' => $request->input('title'),
                'image_url' => $request->input('image_url'),
            ]
        );

        $bookmark->update(['is_finished' => !$bookmark->is_finished]);

        return response()->json(['message' => 'Finished status toggled successfully', 'bookmark' => $bookmark]);
    }

    public function deleteBookmark($id)
    {
        $bookmark = AnimeBookmark::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$bookmark) {
            return response()->json(['message' => 'Bookmark not found.'], 404);
        }

        $bookmark->delete();

        return response()->json(['message' => 'Bookmark deleted successfully', 'status' => 'deleted']);
    }

    public function showDetail($id)
    {
        try {
            $response = Http::get("https://api.jikan.moe/v4/anime/{$id}");
            if ($response->failed()) {
                return abort(404, 'Anime not found');
            }

            $anime = $response->json()['data'];
            $animeBookmark = AnimeBookmark::where('anime_id', $id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$animeBookmark) {
                return view('home.detail.detail', compact('anime'))->with('animeBookmark', null);
            }

            return view('home.detail.detail', compact('anime', 'animeBookmark'));
        } catch (\Exception $e) {
            return abort(500, 'An error occurred while fetching anime details');
        }
    }
}
