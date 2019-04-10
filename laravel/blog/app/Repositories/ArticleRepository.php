<?php

namespace App\Repositories;

use App\Model\Article;

class ArticleRepository implements RepositoryInterface
{
    protected $instance;

    public function __construct(Article $instance)
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
        return $this->instance->where('slug', $id)->update($data);
    }

    public function delete($id)
    {
        return $this->instance->where('slug', $id)->delete();
    }

    public function show($id)
    {
        $instance = $this->instance;

        if(is_int($id))
        {
            return $instance->find($id);
        }

        return $instance->where('slug', $id)->first();
    }
}
