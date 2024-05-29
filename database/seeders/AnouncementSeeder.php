<?php

namespace Database\Seeders;

use App\Models\Anouncement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Anouncement::create([
            'title' => 'Welcome New Users! Please read this before posting!',
            'description' => 'Congratulations, you have found the Community! Before you make a new topic or post, please read community guidelines.',
            'is_active' => true,
        ]);
    }
}
