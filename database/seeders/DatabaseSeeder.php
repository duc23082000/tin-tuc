<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        for($i=0; $i<25; $i++) {
            Post::create([
                'title' => fake()->title(),
                'content' => fake()->text(),
                // 'created_by_id ' => 1,
                // 'modified_by_id' => 1,
            ]);
        }

        
    }
}
