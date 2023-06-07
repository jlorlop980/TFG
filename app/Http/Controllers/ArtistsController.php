<?php

namespace App\Http\Controllers;

use App\Models\Artists;
use App\Models\Songs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        // Validate request
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Some fields are missing'], 400);
        }

        //check if the artist name already exist
        $artistCheck = Artists::where('name', $request->name)->first();
        if ($artistCheck) {
            return response()->json(['message' => 'Artist name already exist'], 400);
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
        //check first if the user is admin
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'You are not authorized to perform this action'], 401);
        }

        //edit an artist by id and if not exist return 404
        $artist = Artists::find($id);
        if (!$artist) {
            return response()->json([
                'message' => 'Artist not found'
            ], 404);
        }

        //update only the values that are in the request
        if (!$request->name && !$request->bio && !$request->mail) {
            return response()->json([
                'message' => 'Bad request'
            ], 400);
        }
        if ($request->name) {
            $artist->name = $request->name;
        }
        if ($request->bio) {
            $artist->bio = $request->bio;
        }
        if ($request->mail) {
            $artist->mail = $request->mail;
        }

        $artist->save();
        return $artist;
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
