<?php

namespace App\Http\Controllers\Trainee;

use App\Models\Booking;
use App\Models\TrainerClass;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $traineeId = $request->user()->id;
        return Booking::where('trainee_id', $traineeId)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'class_id' => 'required|exists:trainer_classes,id', // Ensure it references the 'trainer_classes' table
        ]);

        $class = TrainerClass::find($validatedData['class_id']);

        // Ensure no time conflict
        $conflictingBooking = Booking::where('trainee_id', $request->user()->id)
            ->where('class_date', $class->date)
            ->exists();

        if ($conflictingBooking) {
            return response()->json(['error' => 'You already have a booking at this time'], 422);
        }

        // Check class capacity (example max: 20)
        if ($class->trainees_count >= 20) {
            return response()->json(['error' => 'Class is full'], 422);
        }

        // Create booking
        return Booking::create([
            'trainee_id' => $request->user()->id,
            'class_id' => $class->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        if ($booking->trainee_id != auth()->id()) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking canceled']);
    }
}