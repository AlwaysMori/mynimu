@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 mt-6">
    <h1 class="text-3xl font-bold text-white mb-4">Finished Anime</h1>
    <hr class="border-t-2 border-gray-600 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($bookmarks as $bookmark)
            <div class="photo-card bg-gray-800 p-6 border border-blue-800 fade-in rounded-none solid-shadow hover:shadow-lg transition flex relative">
                <img src="{{ $bookmark->image_url }}" alt="{{ $bookmark->title }}" class="w-32 h-32 object-cover rounded">
                <div class="flex-1 pl-4">
                    <h3 class="text-xl font-bold text-white">{{ $bookmark->title }}</h3>
                    <div class="mt-4 flex justify-between">
                        <a href="{{ url('/anime/detail/'.$bookmark->anime_id) }}" class="p-2 bg-blue-600 text-white rounded-none photo-card solid-shadow hover:bg-blue-700 transition">Details</a>
                        <form action="{{ url('/anime/bookmark/'.$bookmark->id) }}" method="POST" onsubmit="return confirm('Remove from finished list?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-600 text-white rounded-none photo-card solid-shadow hover:bg-red-700 transition">Remove</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-400">You have not finished any anime yet.</p>
        @endforelse
    </div>
</div>
@endsection
