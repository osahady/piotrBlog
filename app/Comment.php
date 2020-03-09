<?php

namespace App;

// use App\BlogPost;
use App\Scopes\LatestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SebastianBergmann\CodeCoverage\Node\Builder;

class Comment extends Model
{
    //
    use SoftDeletes, Taggable;

    protected $fillable = ['user_id', 'content'];

    //laravel is smart enough to hide every thing in this array
    //so that it does not appear in json response
    protected $hidden = ['deleted_at', 'commentable_type', 'commentable_id', 'user_id'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

   

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    
}
