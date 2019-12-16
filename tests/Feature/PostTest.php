<?php

namespace Tests\Feature;

use App\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
   
    public function testNoBlogPostWhenNothingInDatabase()
    {

        $response = $this->get('/posts');
        $response->assertSeeText('No blog posts yet!');
        
    }

    public function testSee1BlogPostWhenThereIs1()
    {
        //Arrange
        $post = new BlogPost();
        $post->title = 'New title';
        $post->content = 'Content of the blog post for testing purposes only';
        $post->save();

        //Act
        $response = $this->get('/posts');

        //Assert
        $response->assertSeeText('New title');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title'
        ]);

        

    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertEquals(session('success'), 'Blog Post was created!');
    }

    public function testStoreFail()
    {
        $params = [
            'title' => 'x',
            'content' => 'y'
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');
        
        $message = session('errors')->getMessages();

        $this->assertEquals($message['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($message['content'][0], 'The content must be at least 10 characters.');

        // dd($message->getMessages());
        
    }

    public function testUpdateValid()
    {
        $post = new BlogPost();
        $post->title = 'New Title';
        $post->content = 'Content of the blog post';
        $post->save();

        $this->assertDatabaseHas('blog_posts', $post->toArray());

        $params = [
            'title' => 'New Title Modified',
            'content' => 'Content of the blog post has been modified'
        ];

        $this->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertEquals(session('success'), 'Blog post was updated!');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title Modified',
            'content' => 'Content of the blog post has been modified'
        ]);
    }

    public function testDelete()
    {
        
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', $post->toArray());

        $this->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('danger');

        $this->assertEquals(session('danger'), 'The post has been deleted!');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
    }

    private function createDummyBlogPost() : BlogPost
    {
        $post = new BlogPost();
        $post->title = 'New title';
        $post->content = 'Content of the post to be deleted';
        $post->save();
        return $post;
    }

    
}
