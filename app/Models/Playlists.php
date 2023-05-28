<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlists extends Model
{
    protected $table = 'playlists';
    use HasFactory;
    protected $fillable = [
        'name',
        'id_users',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];


    public function songs()
    {
        return $this->belongsToMany(Songs::class, 'song_playlist', 'id_playlist', 'id_song')->withTimestamps();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }


}
