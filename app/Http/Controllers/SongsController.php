<?php

namespace App\Http\Controllers;

use App\Models\Artists;
use App\Models\Favorites;
use App\Models\Genres;
use App\Models\song_playlist;
use App\Models\Songs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SongsController extends Controller
{

    public function getAllSongs()
    {
        $songs = Songs::with('artist','genre')->get();
        return response()->json($songs);
    }

    public function create(Request $request) //admin
    {
        // Verificar si el usuario actual es un administrador
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'You are not authorized to perform this action'], 401);
        }

        //check if the request has all the fields
        if (!$request->name || !$request->id_artist || !$request->id_genre || !$request->song || !$request->duration) {
            return response()->json([
                'message' => 'Please provide all the required fields'
            ], 422);
        }

        // Verificar si el artista y el género existen
        $artist = Artists::find($request->id_artist);
        if (!$artist) {
            return response()->json([
                'message' => 'Artist not found'
            ], 404);
        }
        $genre = Genres::find($request->id_genre);
        if (!$genre) {
            return response()->json([
                'message' => 'Genre not found'
            ], 404);
        }
        //verificar si el nombre de la canción ya existe
        $song = Songs::where('name', $request->name)->first();
        if ($song) {
            return response()->json([
                'message' => 'Song already exists'
            ], 409);
        }

        // Decodificar el archivo de audio y asignar un nombre aleatorio para evitar que se pisen los nombres
        $datosBinarios = base64_decode($request->song);
        $fileName = Str::random(10) . '.mp3';

        // Guardar el archivo en la carpeta public/storage
        file_put_contents(public_path('storage/' . $fileName), $datosBinarios);

        $song = Songs::create([
            'name' => $request->name,
            'id_artist' => $request->id_artist,
            'id_genre' => $request->id_genre,
            'url' => 'storage/' . $fileName,
            'duration' => $request->duration
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

        return response()->json($songs);
    }

public function getSongsByArtist($id)
    {
        $songs = Songs::with('artist','genre')->where('id_artist', $id)->get();

        return response()->json($songs);
    }

    public function edit(Request $request,$id) //admin  // Está ruto dificilmente se usará pero por si acaso
    {
        //check first if the user is admin
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'You are not authorized to perform this action'], 401);
        }
        //check if the song exist
        $song = Songs::find($id);
        if (!$song) {
            return response()->json([
                'message' => 'Song not found'
            ], 404);
        }
        //check if the request has at least 1 field to update
        if (!$request->name && !$request->id_artist && !$request->id_genre && !$request->song && !$request->duration) {
            return response()->json([
                'message' => 'Please provide at least one field to update'
            ], 400);
        }

        //check value in case the request has genre id or artist id that the artist or genre exist before updating
        if ($request->id_genre) {
            $genre = Genres::find($request->id_genre);
            if (!$genre) {
                return response()->json([
                    'message' => 'Genre not found'
                ], 404);
            }
        }
        if ($request->id_artist) {
            $artist = Artists::find($request->id_artist);
            if (!$artist) {
                return response()->json([
                    'message' => 'Artist not found'
                ], 404);
            }
        }
        //update the song
        $song->update($request->all());
        return response()->json($song);
    }


    public function deleteById($id) //admin  // Está ruto dificilmente se usará pero por si acaso
    {
        //check first if the user is admin
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'You are not authorized to perform this action'], 401);
        }
        //check if the song exist
        $song = Songs::find($id);
        if (!$song) {
            return response()->json([
                'message' => 'Song not found'
            ], 404);
        }



        //delete the register from the playlist table and the favorites table that has this song id
        $SongPlaylists = song_playlist::where('id_song', $id)->delete();



        $favorites = Favorites::where('id_song', $id)->get();
        foreach ($favorites as $favorite) {
            $favorite->delete();
        }

        //delete the song
        $song->delete();
        return response()->json([
            'message' => 'Song deleted successfully'
        ]);
    }
}
