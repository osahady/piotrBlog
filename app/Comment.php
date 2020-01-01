<?php

namespace App;

// use App\BlogPost;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //
    use SoftDeletes;

    public function blogPost()
    {
        return $this->belongsTo('App\BlogPost');
    }

    public static function boot()
    {
        parent::boot();

        //تسجيل النطاق العالمي في النوذج بعد إنشاء صف LatestScope
        //عبر تنفيذ الواجهة العالمية Scope
        static::addGlobalScope(new LatestScope);

    }
}
