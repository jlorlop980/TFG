<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use App\Models\Songs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GenresController extends Controller
{

    public function getAllGenres()
    {
        return  Genres::all();
    }

    public function create(Request $request)
    {
        //check if is admin first byt the is_admin column
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'You are not authorized to perform this action'], 401);
        }

        //check if the request has a name
        if (!$request->name) {
            return response()->json(['message' => 'Genre name is required'], 400);
        }

        //Check if the genre name already exist
        $genreCheck = Genres::where('name', $request->name)->first();
        if ($genreCheck) {
            return response()->json(['message' => 'Genre name already exist'], 400);
        }


        //create a new genre
        $genre = Genres::create([
            'name' => $request->name
        ]);
        return $genre;

    }

    public function genreById(Request $request)
    {
        //get a genre by id
        $genre = Genres::find($request->id);
        return $genre;
    }

    public function deleteGenreById($id)
    {
        //check if is admin first byt the is_admin column
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'You are not authorized to perform this action'], 401);
        }
        //change the genre of the songs with this genre id to 1 (NoGenre)
        $songs = Songs::where('id_genre', $id)->get();
        foreach ($songs as $song) {
            $song->id_genre = 1;
            $song->save();
        }

        $genre = Genres::find($id);
        $genre->delete();
        return $genre;
    }

    public function updateGenreById(Request $request, $id)
    {
        //check first if the user is admin
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'You are not authorized to perform this action'], 401);
        }

        //check if the genre exist and if the request has a name
        $genre = Genres::find($id);
        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        if (!$request->name) {
            return response()->json(['message' => 'Genre name is required'], 400);
        }
        //Check if the genre name already exist
        $genreCheck = Genres::where('name', $request->name)->first();
        if ($genreCheck) {
            return response()->json(['message' => 'Genre name already exist'], 400);
        }

        //update the genre
        $genre->name = $request->name;
        $genre->save();
        return $genre;
    }
}
