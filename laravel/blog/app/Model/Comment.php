<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Draft status
     *
     * @var int STATUS_DRAFT
     */
    const STATUS_DRAFT = 0;

    /**
     * Comment visible
     *
     * @var int STATUS_ALIVE
     */
    const STATUS_ALIVE = 1;

    /**
     * Comment deleted
     *
     * @var int STATUS_SOFT_DELETED
     */
    const STATUS_SOFT_DELETED = 2;

    /**
     * Attach author
     *
     * @var array $with
     */
    protected $with = ['author'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
    ];

    /**
     * Author object
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\Model\User', 'creator_id', 'id');
    }
}
