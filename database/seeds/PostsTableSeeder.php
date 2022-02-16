<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return voidさ
     */
    public function run()
    {
        factory(App\Post::class, 10)
            ->create()
            ->each(function(App\Post $post) {
                $post->user()->save(factory(App\User::class)->make());
            });        
    }
}
