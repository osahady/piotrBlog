<?php

namespace App;

use App\Author;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //

    public function author()
    {
        return $this->belongsTo('Author');
    }
}
