<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Post::class, 50)
            ->create()
            ->each(function(App\Post $post) {
                $post->user()->save(factory(App\User::class)->make());
            });        
    }
}
