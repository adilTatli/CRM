<?php

namespace App\Http\Controllers\API\Additional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Additional\UserStoreRequest;
use App\Http\Requests\Additional\UserUpdateRequest;
use App\Http\Resources\Additional\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use jeremykenedy\LaravelRoles\Models\Role;

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
                'users' => UserResource::collection($users),
            ]);
        } catch (Exception $e) {
            Log::error('Failed to fetch users: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch users. Please try again later.'
            ], 500);
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
                'user' => new UserResource($user),
                'message' => 'User created successfully',
            ], 201);
        } catch (Exception $e) {
            Log::error('Failed to create user: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to create user. Please try again later.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try {
            return response()->json([
                'user' => new UserResource($user),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch user with ID ' . $user->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch user. Please try again later.'
            ], 500);
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
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update user with ID ' . $user->id . ': ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update user. Please try again later.'
            ], 500);
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
            ]);
        } catch (Exception $e) {
            Log::error('Failed to delete user with ID ' . $user->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to delete user. Please try again later.'
            ], 500);
        }
    }
}
