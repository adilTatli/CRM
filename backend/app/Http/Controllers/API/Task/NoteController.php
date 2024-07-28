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

class NoteController extends Controller
{
    use HandlesResourceTrait;

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoteRequest $request, Task $task): JsonResponse
    {
        return $this->handleStore($request, Note::class, NoteResource::class, 'Note', [
            'task_id' => $task->id,
            'user_id' => $request->user()->id,
        ], ['user']);
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, Note $note): JsonResponse
    {
        return $this->handleDestroy('Note', $note, $task);
    }
}
