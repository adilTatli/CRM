<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * User authorization and issuance of a temporary token.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request)
    {
        try {
            $request->validated();

            if (!Auth::attempt($request->only('email', 'password'))) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.']
                ]);
            }

            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            Log::info('User logged in successfully.', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ]);
        } catch (ValidationException $e) {
            Log::warning('ValidationException during login', [
                'errors' => $e->errors(),
                'email' => $request->input('email'),
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Exception during login', [
                'exception' => $e,
                'email' => $request->input('email'),
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'message' => 'Failed to login. Please try again later.'
            ], 500);
        }
    }

    /**
     * User logout (deleting all tokens).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            Log::info('User logged out successfully.', [
                'user_id' => $request->user()->id,
                'email' => $request->user()->email,
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'message' => 'Logged out successfully'
            ]);
        } catch (Exception $e) {
            Log::error('Exception during logout', [
                'exception' => $e,
                'user_id' => optional($request->user())->id,
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'message' => 'Failed to logout. Please try again later.'
            ], 500);
        }
    }
}
