<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = [
            'Super Admin' => 5,
            'Admin' => 4,
            'Doctor' => 3,
            'Nurse' => 2,
            'Receptionist' => 1,
            'Patient' => 0,
        ];

        foreach ($roles as $name => $level) {
            Role::create([
                'name' => $name,
                'level' => $level,
            ]);
        }
    }
}
