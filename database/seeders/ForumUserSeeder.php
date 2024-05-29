<?php

namespace Database\Seeders;

use App\BulkActions\GenerateAvatar;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForumUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 30; $i++) {
            $user = [
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'username' => fake()->unique()->userName(),
                'email' => fake()->unique()->safeEmail(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'is_admin' => false,
                'email_verified_at' => now(),
            ];

            if (!file_exists(public_path('forum/avatar/'))) {
                mkdir(public_path('forum/avatar/'), 777, true);
            }

            $user['avatar'] = GenerateAvatar::make($user['first_name'], public_path("forum/avatar/{$user['first_name']}.png"));

            User::create($user);
        }
    }
}
