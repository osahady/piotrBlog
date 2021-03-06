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
        $response->assertSeeText('No comments yet');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title'
        ]); 

    }

    public function testSee1BlogPostWithComments()
    {
        $user = $this->user();
        //arrange  إنشاء المقالة بواسطة تابع جاهز 
        //createDummyBlogPost();
        $post = $this->createDummyBlogPost();

        //إنشاء أربعة تعليقات للمقالة بواسطة المعمل 
        factory(Comment::class, 4)->create([
            'commentable_id' => $post->id,
            'commentable_type' => 'App\BlogPost',
            'user_id' => $user->id
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

       

        $this->actingAs($this->user())
            ->post('/posts', $params)
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

        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');
        
        $message = session('errors')->getMessages();

        $this->assertEquals($message['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($message['content'][0], 'The content must be at least 10 characters.');

        // dd($message->getMessages());
        
    }

    public function testUpdateValid()
    {
        //كلمة هذا تشير إلى عنصر من الصف الحالي أو مورثه
        // تم إنشاء تابع في الصف المورث TestCase
        //تم هنا استدعاء هذا التابع هنا لإنشاء مستخدم 
        //عبر المعمل factory(User::class)->create()
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', $post->toArray());

        $params = [
            'title' => 'New Title Modified',
            'content' => 'Content of the blog post has been modified'
        ];

        $this->actingAs($user)
            ->put("/posts/{$post->id}", $params)
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
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', $post->toArray());

        $this->actingAs($user)
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('danger');

        $this->assertEquals(session('danger'), 'The post has been deleted!');
        // $this->assertDatabaseMissing('blog_posts', $post->toArray());
        $this->assertSoftDeleted('blog_posts', $post->toArray());
    }

    private function createDummyBlogPost($userId = null) : BlogPost
    {
        // $post = new BlogPost();
        // $post->title = 'New title';
        // $post->content = 'Content of the post to be tested';
        // $post->save();

        return factory(BlogPost::class)->states('new-title')->create(
            [
                //ثنائية الاستفهام وجدت في الإصدار السابع من بي اتس بي
                //وتعني إذا كان الشرط لا يؤول للعدم فضع قيمته
                //وإذا كان يؤول للعدم فضع القيمة 
                //التي تأتي بعد إشارتي الاستفهام
                'user_id' => $userId ?? $this->user()->id,
            ]
        );

        // return $post;
    }

    
}
