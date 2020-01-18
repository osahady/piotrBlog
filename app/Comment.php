<?php

namespace App;

// use App\BlogPost;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SebastianBergmann\CodeCoverage\Node\Builder;

class Comment extends Model
{
    //
    use SoftDeletes;

    public function blogPost()
    {
        return $this->belongsTo('App\BlogPost');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public static function boot()
    {
        parent::boot();

        //تسجيل النطاق العالمي في النوذج بعد إنشاء صف LatestScope
        //عبر تنفيذ الواجهة العالمية Scope
        // static::addGlobalScope(new LatestScope);

    }
}
