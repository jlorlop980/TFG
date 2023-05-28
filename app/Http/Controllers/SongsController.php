<?php

namespace App\Http\Controllers;

use App\Models\Songs;
use Illuminate\Http\Request;

class SongsController extends Controller
{

    public function getAllSongs()
    {
        $songs = Songs::with('artist','genre')->get();
        return response()->json($songs);
    }

    public function create(Request $request)
    {
        $song = Songs::create([
            'name' => $request->name,
            'id_artist' => $request->id_artist,
            'id_genre' => $request->id_genre_,
            'url' => $request->url
        ]);
    }

    //filtros por id artista y genero
    public function getSongById($id)
    {
        $song = Songs::find($id);
        if (!$song) {
            return response()->json([
                'message' => 'Song not found'
            ], 404);
        }
        return response()->json($song);
    }

    public function getSongsByGenre($id)
    {
        $songs = Songs::with('artist','genre')->where('id_genre', $id)->get();
        /*
        $songs = Songs::join('artists', 'songs.id_artist', '=', 'artists.id')
            ->join('genres', 'songs.id_genre', '=', 'genres.id')
            ->select('songs.*', 'artists.name as artist_name', 'genres.name as genre_name')
            ->where('songs.id_genre', $id)
            ->get();
        */
        return response()->json($songs);
    }

public function getSongsByArtist($id)
    {
        $songs = Songs::with('artist','genre')->where('id_artist', $id)->get();
        /*
        $songs = Songs::join('artists', 'songs.id_artist', '=', 'artists.id')
            ->join('genres', 'songs.id_genre', '=', 'genres.id')
            ->select('songs.*', 'artists.name as artist_name', 'genres.name as genre_name')
            ->where('songs.id_artist', $id)
            ->get();
        */
        return response()->json($songs);
    }

    public function edit($id)
    {
        //
    }


    public function deleteById($id)
    {
        $song = Songs::find($id);
        if (!$song) {
            return response()->json([
                'message' => 'Song not found'
            ], 404);
        }
        $song->delete();
        return response()->json([
            'message' => 'Song deleted'
        ]);
    }
}
