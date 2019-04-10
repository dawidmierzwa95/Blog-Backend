<?php

namespace App\Http\Controllers;

use App\Model\Comment;
use App\Repositories\CommentRepository;
use App\Transformers\CommentTransformer;
use App\Repositories\ArticleRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * @var CommentRepository $repository
     */
    private $repository;

    /**
     * @param CommentRepository $repository
     */
    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Comment structure validator
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'content' => ['required', 'string'],
            'creator_id' => ['int'],
            'article_id' => ['int'],
        ]);
    }

    /**
     * Get comments for specific Article
     *
     * @param  int $articleId
     * @return Collection
     */
    public function index(int $articleId)
    {
        $user = Auth::user();
        $showHiddenRecords = false;

        if ($user && $user->hasPermission('ADMIN')) {
            $showHiddenRecords = true;
        }

        return (new CommentTransformer())->transformCollection($this->repository->getByArticleId($articleId, $showHiddenRecords));
    }

    public function show() {}

    /**
     * Create new instance of Comment
     *
     * @param  Request $request
     * @param  ArticleRepository $articleRepository
     * @param  int $articleId
     * @return mixed
     */
    public function store(Request $request, ArticleRepository $articleRepository, int $articleId)
    {
        $user = Auth::user();
        $article = $articleRepository->show($articleId);

        if($article)
        {
            $data = [
                'content' => $request->get('content'),
                'creator_id' => $user->id,
                'article_id' => $article->id
            ];

            $validator = $this->validator($data);

            if($validator->fails())
            {
                return ['errors' => $validator->errors()];
            }

            $comment = $this->repository->create($data);
            $comment->author = $user;

            return (new CommentTransformer())->transform($comment);
        }

        return [];
    }

    /**
     * Update specific Comment
     *
     * @param  Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $comment = Comment::find($request->get('id'));

        if($comment && Auth::user()->id === $comment->creator_id)
        {
            $data = [
                'content' => $request->get('content')
            ];

            $validator = $this->validator($data);

            if($validator->fails())
            {
                return ['errors' => $validator->errors()];
            }

            $comment = $this->repository->update($data, $request->get('id'));

            return (new CommentTransformer())->transform($comment);
        }

        return [];
    }

    /**
     * Set comment's status
     *
     * @param  Request $request
     * @param  int $id
     * @return mixed
     */
    public function setStatus(Request $request, int $id)
    {
        $user = Auth::user();
        $newStatus = $request->get('status');
        $comment = $this->repository->show($id);
        $passed = false;

        if($comment)
        {
            switch($newStatus)
            {
                case Comment::STATUS_SOFT_DELETED:
                    if($user->id === $comment->creator_id)
                    {
                        $passed = true;
                    }
                    break;

                case Comment::STATUS_ALIVE:
                    if($user->hasPermission('ADMIN'))
                    {
                        $passed = true;
                    }
                    break;
            }
        }

        if($passed)
        {
            return (new CommentTransformer())->transform($this->repository->update(["status" => $newStatus], $comment->id));
        }

        return ["errors" => []];
    }
}
