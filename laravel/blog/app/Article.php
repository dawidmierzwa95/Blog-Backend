<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $with = ['author', 'tags'];

    public function author()
    {
        return $this->belongsTo('App\User', 'creator_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'article_tag', 'article_id', 'id');
    }
}
