<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Post::factory()
        ->count(100)
        ->create
        ([
            'title' => Str::random(rand(10, 25)),
            'caption' => Str::random(rand(10, 255)),
        ])
        ->each(function($post)
        {
            Comment::factory()
            ->count(5)
            ->create
            ([
                'post_id' => $post->id,
                'body' => Str::random(rand(10,100)),
            ]);
        });
    }
}
