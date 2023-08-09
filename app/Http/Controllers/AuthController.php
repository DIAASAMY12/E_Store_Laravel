<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Registration successful'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'message' => 'Login successful',
            'email' => $request->email,
            'name' => $user->username,
            'token' => $user->createToken('auth-token')->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful']);
    }


    public function refresh(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'token' => $request->user()->createToken('auth-token')->plainTextToken,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
            'token' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $lastToken = $user->tokens->last();

        if (!$this->isValidResetToken($user, $request->token)) {
            return response()->json(['message' => 'Invalid token'], 400);
        }

        $this->updatePasswordAndRevokeTokens($user, $request->password);

        return response()->json(['message' => 'Password reset successful']);
    }

    private function isValidResetToken(User $user, $token)
    {
        $lastToken = $user->tokens->last();

        if (!$lastToken) {
            return false;
        }

//        if (!$this->tokenNotExpired($lastToken->created_at)) {
//            return false; // Token has expired
//        }


//        return hash_equals($lastToken->token, hash('sha256', $token));
        return $lastToken;
    }

//    private function tokenNotExpired($createdAt)
//    {
//        $expirationTime = config('sanctum.expiration') * 60; // Convert minutes to seconds
//        return now()->diffInSeconds($createdAt) <= $expirationTime;
//    }

    private function updatePasswordAndRevokeTokens(User $user, $newPassword)
    {
        $user->forceFill([
            'password' => Hash::make($newPassword),
        ])->save();

        $user->tokens()->delete();
    }
}
