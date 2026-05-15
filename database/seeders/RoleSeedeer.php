<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Enums\RoleEnum;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => RoleEnum::ADMIN->value,
                'permissions' => ['*']
            ],
            [
                'name' => 'Event Organizer',
                'slug' => RoleEnum::ORGANIZER->value,
                'permissions' => ['events:*', 'participants:*']
            ],
            [
                'name' => 'Peserta',
                'slug' => RoleEnum::USER->value,
                'permissions' => ['events:read', 'tickets:*']
            ],
        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(
                ['slug' => $roleData['slug']],
                $roleData
            );
        }

        $this->command->info('✅ RoleSeeder completed! 3 roles created.');
    }
}