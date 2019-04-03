<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    const STATUS_DRAFT = 0;
    const STATUS_ALIVE = 1;
    const STATUS_SOFT_DELETED = 2;

    protected $with = ['author'];

    public function author()
    {
        return $this->belongsTo('App\User', 'creator_id', 'id');
    }
}
