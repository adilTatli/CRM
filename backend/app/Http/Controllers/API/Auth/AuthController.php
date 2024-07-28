<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

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

            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.']
                ]);
            }

            $user = Auth::user();

            Log::info('User logged in successfully.', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], Response::HTTP_OK);
        } catch (ValidationException $e) {
            Log::warning('ValidationException during login', [
                'errors' => $e->errors(),
                'email' => $request->input('email'),
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            Log::error('Exception during login', [
                'exception' => $e,
                'email' => $request->input('email'),
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'message' => 'Failed to login. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
            JWTAuth::invalidate(JWTAuth::getToken());

            Log::info('User logged out successfully.', [
                'user_id' => $request->user()->id,
                'email' => $request->user()->email,
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'message' => 'Logged out successfully'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Exception during logout', [
                'exception' => $e,
                'user_id' => optional($request->user())->id,
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'message' => 'Failed to logout. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
