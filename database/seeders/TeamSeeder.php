<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Cardiology',
            'Neurology',
            'Radiology',
            'Pediatrics',
            'Orthopedics',
            'Gastroenterology',
            'Dermatology',
            'Emergency',
            'Unassigned'
        ];

        $user = User::find(1);

        foreach ($departments as $departmentName) {
            Team::forceCreate([
                'user_id' => $user->id,
                'name' => $departmentName,
                'personal_team' => false,
            ]);
        }
    }
}
