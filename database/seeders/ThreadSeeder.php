<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::query()->delete();

        for ($i = 1; $i <= 10; $i++) {
            $name = fake()->sentence(2);
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'color' => fake()->hexColor()
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            $title = fake()->sentence(5);
            $thread = Thread::create([
                'user_id' => fake()->numberBetween(2, User::count()),
                'category_id' => fake()->numberBetween(1, Category::count()),
                'parent_id' => null,
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => fake()->sentence(20),
                'visibility' => 'all',
                'is_remove_by_admin' => false,
                'last_activity' => now(),
            ]);

            $titleForParent = fake()->sentence(5);
            $thread->parents()->create([
                'user_id' => fake()->numberBetween(2, User::count()),
                'category_id' => fake()->numberBetween(1, Category::count()),
                'title' => $titleForParent,
                'slug' => Str::slug($titleForParent),
                'description' => fake()->sentence(20),
                'visibility' => 'all',
                'is_remove_by_admin' => false,
                'last_activity' => now(),
            ]);
        }
    }
}
