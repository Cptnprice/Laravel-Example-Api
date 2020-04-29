<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\database\factories\PostFactory;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Post::class,30)->create();
    }
}
