<?php

use App\Comment;
use App\BlogPost;
use App\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $posts = BlogPost::all();

        if($posts->count() === 0){
            $this->command->info('There are no posts, so no comments will be added');
            return;           

        }

        $commentsCount = (int)$this->command->ask('How many Posts do you want?', 150);

        $users = User::all();
        factory(Comment::class, $commentsCount)->make()->each(function($comment) use ($posts, $users){
            $comment->blog_post_id = $posts->random()->id;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
