<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::factory(10)->create();

        User::factory(30)->create()->each(function ($user) use($tags){
            Post::factory(rand(1,4))->create([
                'user_id' => $user->id
            ])->each(function ($posts) use($tags){
                $posts->tags()->attach($tags->random(2));
            });
        });
    }
}
