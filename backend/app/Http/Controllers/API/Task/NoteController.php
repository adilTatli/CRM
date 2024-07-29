<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\NoteRequest;
use App\Http\Resources\Common\NoteResource;
use App\Models\Note;
use App\Models\Task;
use App\Traits\Task\HandlesResourceTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Task/Notes",
 *     description="Operations related to notes"
 * )
 */
class NoteController extends Controller
{
    use HandlesResourceTrait;

    /**
     * @OA\Post(
     *     path="/api/task/tasks/{task}/notes",
     *     summary="Create a new note",
     *     tags={"Task/Notes"},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/NoteRequest"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Note created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/NoteResource")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error creating note",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function store(NoteRequest $request, Task $task): JsonResponse
    {
        return $this->handleStore($request, Note::class, NoteResource::class, 'Note', [
            'task_id' => $task->id,
            'user_id' => $request->user()->id,
        ], ['user']);
    }

    /**
     * @OA\Put(
     *     path="/api/task/tasks/{task}/notes/{note}",
     *     summary="Update a note",
     *     tags={"Task/Notes"},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="note",
     *         in="path",
     *         required=true,
     *         description="ID of the note",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/NoteRequest"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Note updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/NoteResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error updating note",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function update(NoteRequest $request, Task $task, Note $note): JsonResponse
    {
        return $this->handleUpdate(
            $request,
            NoteResource::class,
            'Note',
            $note,
            $task,
            ['user']
        );
    }

    /**
     * @OA\Delete(
     *     path="/api/task/tasks/{task}/notes/{note}",
     *     summary="Delete a note",
     *     tags={"Task/Notes"},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="note",
     *         in="path",
     *         required=true,
     *         description="ID of the note",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Note deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden if note does not belong to the task",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error deleting note",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function destroy(Task $task, Note $note): JsonResponse
    {
        return $this->handleDestroy('Note', $note, $task);
    }
}
