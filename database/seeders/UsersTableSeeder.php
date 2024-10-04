<?php
namespace Database\Seeders;

use App\Models\Trainer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'), // Use bcrypt for hashing passwords
            'remember_token' => Str::random(10),
        ]);

        // Assign role to user
        $user->assignRole('Admin'); // Assign 'Admin' role to this user
        $user = User::create([
            'name' => 'Mr. Trainer',
            'email' => 'trainer@example.com',
            'password' => bcrypt('password'), // Use bcrypt for hashing passwords
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole('Trainer'); // Assign 'Admin' role to this user
        // Assign role to user
    }

  
}