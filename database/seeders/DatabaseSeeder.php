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
            // Post::create([
            //     'title' => fake()->title(),
            //     'content' => fake()->text(),
            //     'status' =>  rand(0, 1),
            //     'created_by_id ' => 1,
            //     'modified_by_id' => 1,
            // ]);
            $post = new Post();
            $post->title = fake()->title();
            $post->content = fake()->text();
            $post->status = rand(0, 1);
            $post->created_by_id = 1;
            $post->modified_by_id = 1;
            $post->save();
        }

        
    }
}
