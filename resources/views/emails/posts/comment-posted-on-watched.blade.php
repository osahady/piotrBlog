@component('mail::message')
# Comment was posted on post you're watching

Hi {{ $user->name }} 

@component('mail::button', ['url' => route('posts.show', [$comment->commentable->id])])
View Post
@endcomponent

@component('mail::button', ['url' => route('users.show', [$comment->user->id])])
Visit {{ $comment->user->name }} Profile
@endcomponent

@component('mail::panel')
{{ $comment->content }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
