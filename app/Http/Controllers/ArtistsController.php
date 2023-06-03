<?php

namespace App\Http\Controllers;

use App\Models\Artists;
use App\Models\Songs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtistsController extends Controller
{

    public function getAllArtist()
    {
        return  Artists::all();
    }

    public function create(Request $request)
    {
        //check first if the user is admin
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'You are not authorized to perform this action'], 401);
        }
        //create a new artist
        $artist = Artists::create([
            'name' => $request->name,
            'bio' => $request->bio,
            'mail' => $request->mail
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
        //check first if the user is admin
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'You are not authorized to perform this action'], 401);
        }
        //change the artist id to null in the songs table with this artist id
        $songs = Songs::where('id_artist', $id)->get();
        foreach ($songs as $song) {
            $song->id_artist = 1;
            $song->save();
        }

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
