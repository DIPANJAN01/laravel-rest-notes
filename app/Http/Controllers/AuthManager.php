<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthManager extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'string', 'email', 'unique:users'],
            'name' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed'],
        ]);
        $validatedData['password'] = bcrypt($validatedData['password']);
        $savedUser = User::create($validatedData);
        return response()->json([
            'status' => 'success',
            'data' => ['user' => $savedUser]
        ], 201);
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        if (empty(($user))) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        if (!Hash::check($validatedData['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Incorrect credentials'
            ], 401);
        }

        $token = $user->createToken("token")->plainTextToken;
        return response()->json([
            'status' => 'success',
            'token' => $token,
        ], 200);
    }
}
