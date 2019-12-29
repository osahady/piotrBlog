<?php

namespace App;

use App\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;
    //    protected $table = 'blogposts';
    protected $guarded = [];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    //deleting model event
    public static function boot()
    {
        parent::boot();

        static::deleting(function(BlogPost $blogPost){
            $blogPost->comments()->delete();
        });

        static::restoring(function (BlogPost $blogPost){
            $blogPost->comments()->restore();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
