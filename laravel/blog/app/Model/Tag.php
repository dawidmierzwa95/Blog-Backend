<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $with = [];

    /**
     * Attach articles
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany('App\Model\Article', 'article_tag', 'tag_id', 'id');
    }
}
