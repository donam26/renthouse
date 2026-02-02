<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kiểm tra xem admin đã tồn tại chưa
        $existingAdmin = User::where('email', 'admin@gmail.com')->first();

        if (!$existingAdmin) {
            User::create([
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'phone_number' => null,
                'is_admin' => true,
            ]);

            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->warn('Admin user already exists!');
        }
    }
}
