<?php

namespace App\Model;

use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Sluggable;

    /**
     * Attach author and tags
     *
     * @var array $with
     */
    protected $with = ['author', 'tags'];

    /**
     * Author object
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\Model\User', 'creator_id', 'id');
    }

    /**
     * Tags object
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Model\Tag', 'article_tag', 'article_id', 'id');
    }

    /**
     * Slug initialization
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'unique' => true,
            'source' => 'title'
        ];
    }
}
