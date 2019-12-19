<?php

namespace App;

use App\BlogPost;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //

    public function blogPost()
    {
        return $this->belongsTo('BlogPost');
    }
}
