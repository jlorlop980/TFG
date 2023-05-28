<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GenresController extends Controller
{

    public function getAllGenres()
    {
        Auth::user();
        return  Genres::all();
    }

    public function create(Request $request)
    {
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
        $genre = Genres::find($id);
        $genre->delete();
        return $genre;
    }

    public function updateGenreById(Request $request, $id)
    {
        //check if the genre exist and if the request has a name
        $genre = Genres::find($id);
        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }
        if (!$request->name) {
            return response()->json(['message' => 'Genre name is required'], 400);
        }
        //update the genre
        $genre->name = $request->name;
        $genre->save();
        return $genre;
    }
}
