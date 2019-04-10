<?php

namespace App\Repositories;

use App\Model\Comment;

class CommentRepository implements RepositoryInterface
{
    protected $instance;

    public function __construct(Comment $instance)
    {
        $this->instance = $instance;
    }

    public function all()
    {
        return $this->instance->all();
    }

    public function create($data)
    {
        return $this->instance->create($data);
    }

    public function update($data, $id)
    {
        return $this->instance->find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->instance->find($id)->delete();
    }

    public function show($id)
    {
        return $this->instance->find($id);
    }

    public function getByArticleId(int $articleId, bool $showHiddenRecords = false)
    {
        $instance = $this->instance->where('article_id', $articleId);

        if(!$showHiddenRecords) {
            $instance->where('status', Comment::STATUS_ALIVE);
        }

        return $instance->orderBy('created_at', 'asc')->get();
    }
}
