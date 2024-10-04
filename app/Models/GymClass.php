<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymClass extends Model
{
    use HasFactory;
    
    protected $table = "classes";

    // Allow mass assignment on these columns
    protected $fillable = ['trainer_id', 'class_time', 'capacity'];
}

