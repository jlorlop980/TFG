<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SanctumController extends Controller
{
    //register
    public function register(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "mail" => "required|email",
            "password" => "required|min:6",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //check if the mail already exist
        $mailCheck = User::where('mail', $request->mail)->first();
        if ($mailCheck) {
            return response()->json(['message' => 'Mail already exist'], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'mail' => $request->mail,
            'password' => bcrypt($request->password)
        ]);
        //add the sanctum token to the user and store it in a variable
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'User created successfully',
            'token' => $token
        ], 201);
    }
    //login
    public function login(Request $request)
    {
        // check if the request has a mail and password
        if (!$request->mail || !$request->password) {
            return response()->json([
                'message' => 'Mail and password are required'
            ], 400);
        }

        $user = User::where('mail', $request->mail)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        //add the sanctum token to the user
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'User logged in successfully',
            'token' => $token
        ], 200);
    }

    //logout
    public function logout(Request $request)
    {
        //delete the token of the loged in user with sanctum
        $request->user()->currentAccessToken()->delete();

        //devolver mensaje "logout exitoso"
        return response()->json([
            'message' => 'User logged out successfully'
        ], 200);

    }
}
