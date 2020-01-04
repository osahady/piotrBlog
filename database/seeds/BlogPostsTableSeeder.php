<?php

use App\User;
use App\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blogPostsCount = (int)$this->command->ask('How many Posts do you want?', 50);
        $users = User::all();
        factory(BlogPost::class, $blogPostsCount)->make()->each(function($post) use ($users){
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}
