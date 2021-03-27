<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;

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

        return response()->json(compact('user', 'token'));
    }

    // Register user
    public function register(Request $request, RegisterRequest $validation)
    {
        try {
            $user =  User::create([
                'name'           => $request->name,
                'email'          => $request->email,
                'password'       => Hash::make($request->password),
            ]);

            event(new Register($user));

            return $this->successResponse('data has been created successfully', $user, 200);
        } catch (\Exception $e) {
            return $this->failedResponse('data failed to create', 400);
        }
    }
}
