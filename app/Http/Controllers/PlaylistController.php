<?php

namespace App\Http\Controllers;

use App\Models\Playlists;
use App\Models\Songs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{

    public function getAllPlaylist()
    {
        $id= Auth::user()->id;
        $playlist = Playlists::with(['songs.artist', 'songs.genre'])->where('id_users', $id)->get();

        return response()->json($playlist, 200);

    }

    public function createPlaylist(Request $request)
    {
        $id= Auth::user()->id;
        //check if exist a playlist with the same name
        $playlist = Playlists::where('name', $request->name)->where('id_users', $id)->first();
        if ($playlist) {
            return response()->json(['message' => 'This playlist already exist'], 400);
        }
        $playlist = Playlists::create([
            'name' => $request->name,
            'id_users' => $id
        ]);
        return response()->json($playlist, 201);
    }
    public function deletePlaylist($id)
    {
        //check if the playlist is from the user that make the request
        $id_user= Auth::user()->id;
        $playlist = Playlists::where('id', $id)->where('id_users', $id_user)->first();
        if (!$playlist) {
            return response()->json(['message' => 'Playlist not found'], 404);
        }
        $playlist->delete();
        return response()->json(['message' => 'Playlist deleted'], 200);
    }

    //el id es el de la playlist y en la request va el id de la canción
    public function addSongToPlaylist(Request $request, $id)
    {
        //Compruebo que la playlist le pertenece al usuario que hace la petición
        $id_user= Auth::user()->id;
        $playlist = Playlists::where('id', $id)->where('id_users', $id_user)->first();
        if (!$playlist) {
            return response()->json(['message' => 'Playlist not found'], 404);
        }

        //Compruebo que la canción existe
        $song = Songs::where('id', $request->id_song)->first();
        if (!$song) {
            return response()->json(['message' => 'Song not found'], 404);
        }

        //Compruebo que la canción no está ya en la playlist
        $songInPlaylist = $playlist->songs()->where('id_song', $request->id_song)->first();
        if ($songInPlaylist) {
            return response()->json(['message' => 'Song already in the playlist'], 400);
        }

        $playlist->songs()->attach($request->id_song);
        return response()->json(['message' => 'Song added to the playlist'], 200);
    }


    public function removeSongFromPlaylist()
    {
        //
    }
}
