<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home1');
// });

// Route::get('/contact', function(){
//     return view('contact');
// });

/*===============================================================================
//لحماية المسار نقوم باستخدام البرمجية الوسيطة
// لمنع وصول الضيوف غير المسجلين إلى ذلك المسار
// Route::get('/', 'Home1Controller@home')->name('home1')->middleware('auth');
================================================================================*/

Route::get('/', 'Home1Controller@home')->name('home1');

Route::get('/contact', 'Home1Controller@contact')->name('contact');
//عند إضافة مورد فيمكنك فقط إضافة اسم المورد
Route::resource('posts', 'PostController');
Route::get('/posts/tag/{tag}', 'PostTagController@index')->name('posts.tags.index');

Route::resource('posts.comments', 'PostCommentController')->only(['index','store']);
Route::resource('users.comments', 'UserCommentController')->only(['store']);

Route::get('/dashboard', 'PostController@dashboard')->name('dashboard');
Route::resource('users', 'UserController')->only(['show', 'edit', 'update']);

Route::get('mailable', function(){
  $comment = App\Comment::find(1);
  return new App\Mail\CommentPostedMarkdown($comment);
});
//تم إضافة البرمجية الوسيطة لحماية المسار
// فلن يستطيع المتطفل (المستعبط) الذهاب إلى المسار 
// حتى لو كتبه 
Route::get('/secret', 'Home1Controller@secret')
->name('secret')
->middleware('can:home1.secret'); //the name of the Gate (AuthServiceProvider)






//scaffolding
Auth::routes(); //gives 11 routes and 5 controllers

Route::get('/home', 'HomeController@index')->name('home');
