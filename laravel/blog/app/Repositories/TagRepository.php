<?php

namespace App\Repositories;

use App\Model\Tag;

class TagRepository implements RepositoryInterface
{
    protected $instance;

    public function __construct(Tag $instance)
    {
        $this->instance = $instance;
    }

    public function all()
    {
        return $this->instance->all();
    }

    public function create ($data) {}
    public function show ($data) {}
    public function delete ($data) {}
    public function update ($id, $data) {}
}
