<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $user;

    function __construct(Request $request)
    {
        $this->user = $request->get('user');
    }

    public function index(int $articleId)
    {
        $comments = Comment::where('article_id', $articleId);
/*
        if(!$this->user->hasPermissions('ADMIN'))
        {
            $comments->where('status', Comment::STATUS_ALIVE);
        }*/

        return $comments->orderBy('created_at', 'asc')->get();
    }

    public function show() {}

    public function store(Request $request, int $articleId)
    {
        $user = $request->get('user');
        $article = Article::find($articleId);

        if($article)
        {
            $comment = new Comment();

            $comment->content = $request->get('content');
            $comment->creator_id = $user->id;
            $comment->article_id = $article->id;
            $comment->status = Comment::STATUS_ALIVE;
            $comment->save();

            $comment->author = $user;

            return $comment;
        }

        return [];
    }

    public function update(Request $request)
    {
        $user = $request->get('user');
        $comment = Comment::find($request->get('id'));

        if($comment && $user->id === $comment->creator_id)
        {
            $comment->content = $request->get('content');
            $comment->save();

            return $comment;
        }

        return [];
    }

    public function setStatus(Request $request, int $id)
    {
        $newStatus = $request->get('status');
        $user = $request->get('user');
        $comment = Comment::find($id);
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
            $comment->status = $newStatus;

            return ["status" => $comment->save()];
        }

        return ["errors" => []];
    }
}
