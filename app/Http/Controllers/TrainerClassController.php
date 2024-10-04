<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\TrainerClass;
use Illuminate\Http\Request;

class TrainerClassController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function index()
    {
        return Trainer::all();
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'trainer_id' => 'required|exists:trainers,id',
            'class_id' => 'required|exists:gym_classes,id',
        ]);

        return TrainerClass::create($validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainerClass $trainerClass)
    {
        return $trainerClass;
    }

    // ... other methods
}