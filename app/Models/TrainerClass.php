<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerClass extends Model
{
    use HasFactory;
    protected $fillable =['name','email','capacity','class_time	'];
}
