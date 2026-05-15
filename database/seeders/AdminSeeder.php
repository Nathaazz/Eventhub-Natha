<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\RoleEnum;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        User::updateOrCreate(
            ['email' => 'admin@eventhub.com'],
            [
                'name' => 'Super Administrator',
                'email' => 'admin@eventhub.com',
                'password' => Hash::make('password'),
                'role' => RoleEnum::ADMIN->value,
                'phone' => '081234567890',
                'avatar' => null,
                'email_verified_at' => now(),
            ]
        );

        // Organizer
        User::updateOrCreate(
            ['email' => 'organizer@eventhub.com'],
            [
                'name' => 'Event Organizer Kampus',
                'email' => 'organizer@eventhub.com',
                'password' => Hash::make('password'),
                'role' => RoleEnum::ORGANIZER->value,
                'phone' => '081234567891',
                'avatar' => null,
                'email_verified_at' => now(),
            ]
        );

        // Sample User
        User::updateOrCreate(
            ['email' => 'user@eventhub.com'],
            [
                'name' => 'Peserta Biasa',
                'email' => 'user@eventhub.com',
                'password' => Hash::make('password'),
                'role' => RoleEnum::USER->value,
                'phone' => '081234567892',
                'avatar' => null,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ AdminSeeder completed! Users created.');
    }
}