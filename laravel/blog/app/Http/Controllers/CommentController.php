<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(int $articleId)
    {
        $user = Auth::user();
        $comments = Comment::where('article_id', $articleId);

        if(!$user || !$user->hasPermission('ADMIN'))
        {
            $comments->where('status', Comment::STATUS_ALIVE);
        }

        return $comments->orderBy('created_at', 'asc')->get();
    }

    public function show() {}

    public function store(Request $request, int $articleId)
    {
        $user = Auth::user();
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
        $comment = Comment::find($request->get('id'));

        if($comment && Auth::user()->id === $comment->creator_id)
        {
            $comment->content = $request->get('content');
            $comment->save();

            return $comment;
        }

        return [];
    }

    public function setStatus(Request $request, int $id)
    {
        $user = Auth::user();
        $newStatus = $request->get('status');
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
