<?php

namespace App\Http\Controllers\API\Additional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Additional\ScheduleStoreRequest;
use App\Http\Requests\Additional\ScheduleUpdateRequest;
use App\Http\Resources\Additional\ScheduleResource;
use App\Http\Resources\Additional\TechnicianResource;
use App\Models\Schedule;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $technicians = User::technicians()
                ->with(['schedules' => function ($query) {
                    $query->with(['areas']);
                }])
                ->get();

            return TechnicianResource::collection($technicians);
        } catch (Exception $e) {
            Log::error('Error fetching technicians and schedules: ' . $e->getMessage());

            return response()
                ->json(['error' => 'Failed to fetch technicians and schedules.'],
                    Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ScheduleStoreRequest $request)
    {
        $validatedData = $request->validated();

        $startDate = $validatedData['start_date'];
        $endDate = $validatedData['end_date'];
        $startTime = $validatedData['start_time'];
        $endTime = $validatedData['end_time'];
        $technicians = $validatedData['technicians'];
        $areaId = $validatedData['area_id'];

        $dateRange = Schedule::generateDateRange($startDate, $endDate);
        $timeRange = Schedule::generateTimeRange($startTime, $endTime);

        foreach ($dateRange as $date) {
            $schedule = Schedule::where('date', $date)->first();

            if (!$schedule) {
                $schedule = new Schedule([
                    'date' => $date,
                    'start_time' => $timeRange[0]['start'],
                    'end_time' => end($timeRange)['end'],
                ]);
                $schedule->save();
            }

            foreach ($technicians as $technicianId) {
                if (!$schedule->users()->where('user_id', $technicianId)->exists()) {
                    $schedule->users()->attach($technicianId, ['area_id' => $areaId]);
                } else {
                    return response()->json([
                        'message' => "Schedule already exists for technician ID $technicianId on date $date.",
                    ], Response::HTTP_CONFLICT);
                }
            }
        }

        return response()->json([
            'message' => 'Schedules created successfully',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        try {
            $schedule->load(['users']);

            return new ScheduleResource($schedule);
        } catch (Exception $e) {
            Log::error('Error fetching schedule: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch schedule.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ScheduleUpdateRequest $request, Schedule $schedule)
    {
        try {
            $validatedData = $request->validated();
            $startTime = $validatedData['start_time'];
            $endTime = $validatedData['end_time'];
            $newDate = $validatedData['date'];

            $existingSchedule = Schedule::where('date', $newDate)->first();

            if ($existingSchedule) {
                $existingSchedule->users()->syncWithoutDetaching(
                    collect($validatedData['technicians'])->mapWithKeys(function ($technicianId) use ($validatedData) {
                        return [$technicianId => ['area_id' => $validatedData['area_id']]];
                    })
                );

                return response()
                    ->json(['message' => 'Technicians added to existing schedule successfully'], Response::HTTP_OK);
            }

            $timeRange = Schedule::generateTimeRange($startTime, $endTime);

            $schedule->update([
                'date' => $newDate,
                'start_time' => $timeRange[0]['start'],
                'end_time' => end($timeRange)['end'],
            ]);

            $schedule->users()->sync(
                collect($validatedData['technicians'])->mapWithKeys(function ($technicianId) use ($validatedData) {
                    return [$technicianId => ['area_id' => $validatedData['area_id']]];
                })
            );

            return response()->json(['message' => 'Schedule updated successfully'], Response::HTTP_OK);
        } catch (QueryException $e) {
            Log::error('Schedule update error: ' . $e->getMessage());

            return response()->json([
                'message' => 'The schedule could not be updated.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            Log::error('Error updating the schedule: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while updating the schedule.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        try {
            $schedule->users()->detach();

            $schedule->delete();

            return response()->json(['message' => 'Schedule deleted successfully'], Response::HTTP_OK);
        } catch (QueryException $e) {
            Log::error('Schedule delete error: ' . $e->getMessage());

            return response()->json([
                'message' => 'The schedule could not be deleted.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            Log::error('Error deleting the schedule: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while deleting the schedule.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
