<?php

use App\Comment;
use App\BlogPost;
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

        factory(Comment::class, $commentsCount)->make()->each(function($comment) use ($posts){
            $comment->blog_post_id = $posts->random()->id;
            $comment->save();
        });
    }
}
