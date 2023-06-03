<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Songs extends Model
{
    protected $table = 'songs';
    use HasFactory;
    protected $fillable = [
        'name',
        'id_artist',
        'id_genre',
        'url',
        'duration',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];

    public function artist()
    {
        return $this->belongsTo(Artists::class, 'id_artist');
    }
    public function genre()
    {
        return $this->belongsTo(Genres::class, 'id_genre');
    }
    public function playlists()
    {
        return $this->belongsToMany(Playlists::class, 'song_playlist', 'id_song', 'id_playlist')->withTimestamps();
    }
    public function favorites()
    {
        return $this->hasMany(Favorites::class);
    }

}
