<?php

namespace App\Listeners;

use App\Jobs\ThrottledMail;
use App\Events\CommentPosted;
use App\Mail\CommentPostedMarkdown;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\NotifyUsersPostWasCommented;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUsersAboutComment
{
   
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        //المعامل الثاني للإرسال هو من سيتمّ إرسال البريد إليه

        // dd('I was called in response to an event');
        ThrottledMail::dispatch(
            new CommentPostedMarkdown($event->comment),
            $event->comment->commentable->user)
            ->onQueue('low');
        NotifyUsersPostWasCommented::dispatch($event->comment)
            ->onQueue('high');
        
    }
}
