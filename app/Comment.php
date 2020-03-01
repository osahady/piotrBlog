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
