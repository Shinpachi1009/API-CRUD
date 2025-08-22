<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Comment;
use App\Models\Image;
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
            $name = fake()->name();
            $users->push(User::create([
                'name' => $name,
                'email' => str_replace(' ', '', strtolower($name)) . $i . '@example.com',
                'password' => Hash::make('12345678'),
            ]));
        }

        $posts = collect();
        for ($i = 0; $i < 100; $i++) {
            $posts->push(Post::create([
                'title' => fake()->sentence(rand(3, 5)),
                'caption' => fake()->sentence(rand(5, 15)),
                'user_id' => $users->random()->id,
            ]));
        }

        foreach ($posts as $post) {
            for ($j = 0; $j < 5; $j++) {
                Comment::create([
                    'body' => fake()->sentence(rand(5, 15)),
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                ]);
            }
        }

        $albums = collect();
        for ($i = 0; $i < 100; $i++) {
            $albums->push(Album::create([
                'title' => Str::random(rand(10, 25)),
                'user_id' => $users->random()->id,
            ]));
        }

        foreach ($albums as $album) {
            for ($j = 0; $j < 5; $j++) {
                $numLength = rand(1, 5);
                $number = str_pad(mt_rand(0, pow(10, $numLength) - 1), $numLength, '0', STR_PAD_LEFT);
                Image::create([
                    'image_url' => 'https://' . Str::random(5) . '.com/' . $number . '/' . Str::random(rand(3, 10)) . '.jpg',
                    'album_id' => $album->id,
                    'user_id' => $users->random()->id,
                ]);
            }
        }
    }
}
