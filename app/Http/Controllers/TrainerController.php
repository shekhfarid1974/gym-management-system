<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Trainer::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'=>'required',
            'email'=>'required',
            'expertise' => 'required',
            'availability'=>'required'
        ]);

        return Trainer::create($validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(Trainer $trainer)
    {
        return $trainer;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trainer $trainer)
    {
        $validatedData = $request->validate([
            'expertise' => 'required|string',
            'availability' => 'required|date_format:Y-m-d\TH:i:s', // ISO 8601 format
        ]);

        $trainer->update($validatedData);

        return $trainer;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trainer $trainer)
    {
        $trainer->delete();

        return response()->json(['message' => 'Trainer deleted']);
    }
}