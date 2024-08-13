<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Super User',
            'email' => 'superuser@example.com',
            'password' => Hash::make('password'), // On a live system this would be different and more secure, also introduce a password-reset on initial login
        ]);

        $team = Team::forceCreate([
            'user_id' => $user->id,
            'name' => 'Super Admin',
            'personal_team' => false,
        ]);

        $user->teams()->attach($team->id, ['role' => 'admin']);
        $user->current_team_id = $team->id;
        $user->save();

    }
}
