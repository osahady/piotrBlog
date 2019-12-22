<?php

namespace Tests\Feature;

use App\BlogPost;
use App\Comment;
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

    public function testSee1BlogPostWhenThereIs1WithNoComments()
    {
        //Arrange
        $post = $this->createDummyBlogPost();

        //Act
        $response = $this->get('/posts');

        //Assert
        $response->assertSeeText('New Title');
        $response->assertSeeText('no comments');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title'
        ]); 

    }

    public function testSee1BlogPostWithComments()
    {
        //arrange  إنشاء المقالة بواسطة تابع جاهز 
        //createDummyBlogPost();
        $post = $this->createDummyBlogPost();

        //إنشاء أربعة تعليقات للمقالة بواسطة المعمل 
        factory(Comment::class, 4)->create([
            'blog_post_id' => $post->id
        ]);

        //Act
        //هذه التعليمة تقوم بالذهاب إلى مسار فهرس المقالات
        $response = $this->get('/posts');
        //وهذه التعليمة تختبر وجود رقم أربعة في تلك الصفحة آنفة الذكر
        $response->assertSeeText('4');

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
        $post = $this->createDummyBlogPost();

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
        // $post = new BlogPost();
        // $post->title = 'New title';
        // $post->content = 'Content of the post to be tested';
        // $post->save();

        return factory(BlogPost::class)->states('new-title')->create();

        // return $post;
    }

    
}
