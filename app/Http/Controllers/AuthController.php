<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Login user
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = User::where('email', $request->email)->first();

        $user->update([
            'remember_token' => $token
        ]);

        return response()->json(compact('user', 'token'));
    }

    // Register user
    public function register(Request $request, RegisterRequest $validation)
    {
        User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        $user = User::where('email', $request->email)
            ->first(['id', 'first_name', 'last_name', 'email', 'avatar', 'created_at']);

        return $this->sendResponse('success', 'data has been created successfully', $user, 200);
    }
}
