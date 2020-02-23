<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    

    public function posts()
    {
        return $this->hasMany('App\BlogPost');
    }
    
    public function comments()
    {
        return $this->hasMany('App\User');
    }

    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }


    public function scopeWithMostBlogPosts(Builder $query)
    {
        return $query->withCount('posts')->orderBy('posts_count','desc');
    }

    public function scopeWithMostBlogPostsLastMonth(Builder $query)
    {
        return $query->withCount(['posts' => function($query){
            $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
        }])->having('posts_count', '>=', 2)
           ->orderBy('posts_count', 'desc');
    }
}
