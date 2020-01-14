<?php

use App\BlogPost;
use App\Comment;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if ($this->command->confirm('Do you wnat to refresh the database?')) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed');
        }

        Cache::tags(['blog-post'])->flush();
        
        $this->call([
                        UsersTableSeeder::class, 
                        BlogPostsTableSeeder::class, 
                        CommentsTableSeeder::class
                    ]);

    }
}
