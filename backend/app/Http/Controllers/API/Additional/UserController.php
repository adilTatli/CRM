<?php

namespace App\Http\Controllers\API\Additional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Additional\UserStoreRequest;
use App\Http\Requests\Additional\UserUpdateRequest;
use App\Http\Resources\Common\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use jeremykenedy\LaravelRoles\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::all();

            return response()->json([
                'users' => \App\Http\Resources\Common\UserResource::collection($users),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to fetch users: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch users. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        try {
            $request->validated();

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            if ($request->has('role_ids')) {
                $roles = Role::whereIn('id', $request->input('role_ids'))->get();
                $user->syncRoles($roles);
            }

            return response()->json([
                'user' => new \App\Http\Resources\Common\UserResource($user),
                'message' => 'User created successfully',
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error('Failed to create user: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to create user. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try {
            return response()->json([
                'user' => new \App\Http\Resources\Common\UserResource($user),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to fetch user with ID ' . $user->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch user. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $request->validated();

            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            if ($request->has('role_ids')) {
                $roles = Role::whereIn('id', $request->input('role_ids'))->get();
                $user->syncRoles($roles);
            }

            return response()->json([
                'user' => new UserResource($user),
                'message' => 'User updated successfully',
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to update user with ID ' . $user->id . ': ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update user. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->detachAllRoles();
            $user->delete();

            return response()->json([
                'message' => 'User deleted successfully',
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to delete user with ID ' . $user->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to delete user. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
