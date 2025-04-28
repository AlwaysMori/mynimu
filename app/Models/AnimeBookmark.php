<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimeBookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'anime_id',
        'title',
        'image_url',
        'status',
        'is_finished',
        'is_favorite',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
