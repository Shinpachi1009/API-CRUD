<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $users = collect();
        for ($i = 0; $i < 10; $i++) {
            $users->push(User::create([
                'name' => Str::random(rand(10, 30)),
                'email' => Str::random(10) . $i . '@example.com',
                'password' => Hash::make('12345678'),
            ]));
        }

        $posts = collect();
        for ($i = 0; $i < 100; $i++) {
            $posts->push(Post::create([
                'title' => Str::random(rand(10, 25)),
                'caption' => Str::random(rand(10, 255)),
                'user_id' => $users->random()->id,
            ]));
        }

        foreach ($posts as $post) {
            for ($j = 0; $j < 5; $j++) {
                Comment::create([
                    'body' => Str::random(rand(10, 100)),
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                ]);
            }
        }
    }
}
