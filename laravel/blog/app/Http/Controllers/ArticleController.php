<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Model\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Transformers\ArticleTransformer;

class ArticleController extends Controller
{
    /**
     * @var ArticleRepository $repository
     */
    private $repository;

    /**
     * @param ArticleRepository $repository
     */
    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Article structure validator
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'content' => ['required', 'string'],
            'title' => ['required', 'string', 'max:256'],
            'creator_id' => ['int'],
        ]);
    }

    /**
     * Get all articles
     *
     * @param  string $tag
     * @return Collection
     */
    public function index(string $tag = "")
    {
        return (new ArticleTransformer())->transformCollection($this->repository->all());
    }

    /**
     * Show specific Article
     *
     * @param  string $slug
     * @return array
     */
    public function show(string $slug)
    {
        return (new ArticleTransformer())->transform($this->repository->show($slug));
    }

    /**
     * Create new instance of Article
     *
     * @param  Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if($user->hasPermission('ADMIN|COPYWRITER'))
        {
            $data = [
                'content' => $request->get('content'),
                'title' => $request->get('title'),
                'creator_id' => $user->id
            ];

            $validator = $this->validator($data);

            if($validator->fails())
            {
                return ['errors' => $validator->errors()];
            }

            $article = $this->repository->create($data);

            $article->author = $user;

            return (new ArticleTransformer())->transform($article);
        }

        return [];
    }

    /**
     * Update specific Article
     *
     * @param  Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        if(Auth::user()->hasPermission('ADMIN|COPYWRITER') && $article = $this->repository->show($request->get('id')))
        {
            $data = [
                'content' => $request->get('content'),
                'title' => $request->get('title')
            ];

            $validator = $this->validator($data);

            if($validator->fails())
            {
                return ['errors' => $validator->errors()];
            }

            return ["status" => $this->repository->update($data, $article->slug)];
        }

        return [];
    }

    /**
     * Delete specific Article
     * @param  string $slug
     * @return array
     */
    public function delete(string $slug)
    {
        if(Auth::user()->hasPermission('ADMIN'))
        {
            return ["status" => $this->repository->delete($slug)];
        }

        return [];
    }

    /**
     * Set article's image or upload image without owner
     * @param  Request $request
     * @param  string $slug
     * @return array
     */
    public function setImage(Request $request, string $slug = "")
    {
        $file = $request->file('file');

        if(!Auth::user()->hasPermission('ADMIN|COPYWRITER'))
        {
            return [];
        }

        $path = Storage::disk('public')->put('photos', $file);
        $path = 'http://localhost:8081'.Storage::url($path);

        if($slug && $article = $this->repository->show($slug))
        {
            $this->repository->update(["image" => $path], $article->slug);

            return ["url" => $path];
        }

        return ["default" => $path];
    }
}
