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

/**
 * @OA\Tag(
 *     name="Additional/Users",
 *     description="API Endpoints for managing (additional) users"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/additional/users",
     *     operationId="getUsers",
     *     tags={"Additional/Users"},
     *     summary="Get list of users",
     *     description="Returns list of users",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/UserResourceCommon"))
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/additional/users",
     *     operationId="storeUser",
     *     tags={"Additional/Users"},
     *     summary="Create a new user",
     *     description="Creates a new user and returns the created user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserStoreRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/UserResourceCommon")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/additional/users/{user}",
     *     operationId="getUser",
     *     tags={"Additional/Users"},
     *     summary="Get a user by ID",
     *     description="Returns a single user",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/UserResourceCommon")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/additional/users/{user}",
     *     operationId="updateUser",
     *     tags={"Additional/Users"},
     *     summary="Update a user",
     *     description="Updates the specified user",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/UserResourceCommon")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/additional/users/{user}",
     *     operationId="deleteUser",
     *     tags={"Additional/Users"},
     *     summary="Delete a user",
     *     description="Deletes the specified user",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
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
