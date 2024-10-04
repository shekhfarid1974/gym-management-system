<?php

namespace App\Http\Controllers;

use App\Models\GymClass;
use Illuminate\Http\Request;

class GymClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return GymClass::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'trainer_id' => 'required|exists:trainers,id', // Checks if trainer exists
            'class_time' => 'required', // Validate date and time format
            'capacity' => 'required|integer|min:1', // Ensure capacity is a positive integer
        ]);

        // Check if the trainer has more than 5 classes that day
        $classCount = GymClass::where('trainer_id', $validatedData['trainer_id'])
            ->whereDate('class_time', $validatedData['class_time']) // Filter by the same day
            ->count();

        if ($classCount >= 5) {
            return response()->json(['error' => 'Trainer has reached the maximum number of classes for the day'], 422);
        }

        // Check for time conflicts (same time for the trainer)
        $conflictingClass = GymClass::where('trainer_id', $validatedData['trainer_id'])
            ->where('class_time', $validatedData['class_time']) // Check exact time
            ->exists();

        if ($conflictingClass) {
            return response()->json(['error' => 'Time conflict with another class'], 422);
        }

        return GymClass::create($validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(GymClass $gymClass)
    {
        return $gymClass;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GymClass $gymClass)
    {
        $validatedData = $request->validate([
            'trainer_id' => 'required|exists:trainers,id', // Checks if trainer exists
            'class_time' => 'required|date_format:Y-m-d H:i:s', // Validate date and time format
            'capacity' => 'required|integer|min:1', // Ensure capacity is a positive integer
        ]);

        // Check for time conflicts (same time for the trainer)
        $conflictingClass = GymClass::where('trainer_id', $validatedData['trainer_id'])
            ->where('class_time', $validatedData['class_time'])
            ->where('id', '!=', $gymClass->id) // Exclude the current class
            ->exists();

        if ($conflictingClass) {
            return response()->json(['error' => 'Time conflict with another class'], 422);
        }

        $gymClass->update($validatedData);

        return $gymClass;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GymClass $gymClass)
    {
        $gymClass->delete();

        return response()->json(['message' => 'Gym class deleted']);
    }
}