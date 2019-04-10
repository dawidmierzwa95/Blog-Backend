<?php

namespace App\Http\Controllers;

use App\Model\Tag;
use App\Repositories\TagRepository;
use App\Transformers\TagTransformer;
use Illuminate\Database\Eloquent\Collection;

class TagController extends Controller
{
    /**
     * @var TagRepository $repository
     */
    private $repository;

    /**
     * @param TagRepository $repository
     */
    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all tags
     *
     * @return Collection
     */
    public function index()
    {
        return (new TagTransformer())->transformCollection($this->repository->all());
    }
}
