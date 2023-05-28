<?php

namespace App\Http\Controllers;

use App\Models\Artists;
use Illuminate\Http\Request;

class ArtistsController extends Controller
{

    public function getAllArtist()
    {
        return  Artists::all();
    }

    public function create(Request $request)
    {
        //create a new artist
        $artist = Artists::create([
            'name' => $request->name
        ]);
        return $artist;
    }


    public function getArtistById($id)
    {
        //get an artist by id and if not exist return 404
        $artist = Artists::find($id);
        if (!$artist) {
            return response()->json([
                'message' => 'Artist not found'
            ], 404);
        }
        return $artist;
    }

    public function edit(Request $request,$id)
    {
        //
    }

    public function deleteArtistById($id)
    {
        //delete an artist by id anf if not exist return 404
        $artist = Artists::find($id);
        if (!$artist) {
            return response()->json([
                'message' => 'Artist not found'
            ], 404);
        }
        $artist->delete();
        return $artist;
    }
}
