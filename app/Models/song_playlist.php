<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class song_playlist extends Model
{
    protected $table = 'song_playlist';
    use HasFactory;

    public function playlist()
    {
        return $this->belongsTo(Playlists::class);
    }
    public function song()
    {
        return $this->belongsTo(Songs::class);
    }

}
