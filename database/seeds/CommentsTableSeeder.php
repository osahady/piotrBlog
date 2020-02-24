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
        $users = User::all();

        if($posts->count() === 0 || $users->count() === 0){
            $this->command->info('There are no posts or users, so no comments will be added');
            return;           

        }

        $commentsCount = (int)$this->command->ask('How many Posts do you want?', 150);

        factory(Comment::class, $commentsCount)->make()->each(function($comment) use ($posts, $users){
            $comment->commentable_id = $posts->random()->id;
            $comment->commentable_type = 'App\BlogPost';
            $comment->user_id = $users->random()->id;
            $comment->save();
        });

        factory(Comment::class, $commentsCount)->make()->each(function($comment) use ($users){
            $comment->commentable_id = $users->random()->id;
            $comment->commentable_type = 'App\User';
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
