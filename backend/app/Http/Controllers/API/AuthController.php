<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // Register new user
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'full_name'   => $request->full_name,
            'email'       => $request->email,
            'phone_number'=> $request->phone_number,
            'address'     => $request->address,
            'password'    => Hash::make($request->password),
        ]);

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    // Login user and return JWT token
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        return $this->respondWithToken($token);
    }

    // Get user profile
    public function profile()
    {
        return response()->json(Auth::user());
    }

    // Logout user (invalidate token)
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }

        return response()->json(['message' => 'Successfully logged out']);
    }

    // Refresh JWT token
    public function refresh()
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to refresh token'], 500);
        }
        return $this->respondWithToken($token);
    }

    // Return token response structure
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => JWTAuth::factory()->getTTL() * 60,
            'user'         => Auth::user(),
        ]);
    }
}