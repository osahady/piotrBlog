<?php

namespace App;

use App\BlogPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //
    use SoftDeletes;

    public function blogPost()
    {
        return $this->belongsTo('BlogPost');
    }
}
