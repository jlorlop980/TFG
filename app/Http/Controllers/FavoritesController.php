<?php

namespace App\Http\Controllers;

use App\Models\Favorites;
use App\Models\Songs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{

    public function favoritesByUser()
    {
        $id =Auth::user()->id;
        //get tje favorites joins with the song table
        $favorites = Favorites::where('id_user', $id)->with('songs')->get();

        return response()->json($favorites, 200);
    }


    public function createFavorite($id)
    {
        $idUser = Auth::user()->id;

        //check if the song exist
        $song = Songs::find($id);
        if (!$song) {
            return response()->json(['message' => 'Song not found'], 404);
        }

        $favorite = Favorites::where('id_user', $idUser)->where('id_song', $id)->first();

        if ($favorite) {
            return response()->json(['message' => 'This song is already in your favorites'], 400);
        }

        $favorite = Favorites::create([
            'id_user' => $idUser,
            'id_song' =>$song->id
        ]);

        return response()->json($favorite, 201);
    }


    public function deleteaFavoriteById($id){
        $favorite = Favorites::find($id);
        if($favorite){
            $favorite->delete();
            return response()->json(['message' => 'Favorite deleted'], 200);
        }
        return response()->json(['message' => 'Favorite not found'], 404);
    }

}
