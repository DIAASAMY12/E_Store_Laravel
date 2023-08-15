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
            'first_name' => 'required|string',
            'last_name' => 'required|string',

        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,

        ]);

        return response()->json(['message' => 'Registration successful'], 201);
    }

    public function login(Request $request)
    {
        // Validate user credentials
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Generate Access Token and Refresh Token
            $accessToken = $user->createToken('access_token')->plainTextToken;
            $refreshToken = $user->createToken('refresh_token', ['refresh-token-scope'])->plainTextToken;

            return response()->json([
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
            ]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful']);
    }


    public function refresh(Request $request)
    {

        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Validate the Refresh Token and generate a new Access Token
        $newAccessToken = $user->createToken('access_token')->plainTextToken;

        return response()->json(['access_token' => $newAccessToken]);
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
            return null;
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

        if (!$this->tokenNotExpired($lastToken->created_at)) {
            return false; // Token has expired
        }


//        return hash_equals($lastToken->token, hash('sha256', $token));
        return $lastToken;
    }

    private function tokenNotExpired($createdAt)
    {
        $expirationTime = config('sanctum.expiration') * 1; // Convert minutes to seconds
        return now()->diffInSeconds($createdAt) <= $expirationTime;
    }

    private function updatePasswordAndRevokeTokens(User $user, $newPassword)
    {
        $user->forceFill([
            'password' => Hash::make($newPassword),
        ])->save();

        $user->tokens()->delete();
    }

    public function refreshToken(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required',
        ]);

        $refreshToken = $request->refresh_token;

        $http = new \GuzzleHttp\Client([
            'debug' => true,
        ]);

        try {
            $response = $http->post(config('app.url') . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                    'client_id' => config('passport.client_id'),
                    'client_secret' => config('passport.client_secret'),
                    'scope' => '',
                ],
            ]);

            return response()->json(json_decode((string)$response->getBody(), true));
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return response()->json('Unable to refresh token. Please log in again.', $e->getCode());
        }
    }


}
