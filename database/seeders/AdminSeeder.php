<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()
            ->where('email', 'admin@devspace.com')
            ->delete();

        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Dev Space',
            'username' => 'admin_devspace',
            'email' => 'admin@devspace.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'is_admin' => true,
        ]);
    }
}
