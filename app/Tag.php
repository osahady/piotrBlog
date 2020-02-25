<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    
    public function blogPosts()
    {
        //تستخدم طريقة الـ as لتغيير اسم البيفت 
        // return $this->belongsToMany('App\BlogPost')->withTimestamps()->as('tagged');
        return $this->morphedByMany('App\BlogPost', 'taggable')->withTimestamps()->as('tagged');
        
    }

    public function comments()
    {
        return $this->morphedByMany('App\Comment', 'taggable')->withTimestamps()->as('tagged');
        
    }
}
