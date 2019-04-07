<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(string $tag = "")
    {
        if($tag)
        {
            return Tag::where('name', $tag)->first();
        }

        return Article::all();
    }

    public function show(string $slug)
    {
        return Article::where('slug', $slug)->first();
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if($user->hasPermission('ADMIN|COPYWRITER'))
        {
            $article = new Article();

            $article->content = $request->get('content');
            $article->title = $request->get('title');
            $article->creator_id = $user->id;
            $article->save();

            $article->author = $user;

            return $article;
        }

        return [];
    }

    public function update(Request $request)
    {
        if(Auth::user()->hasPermission('ADMIN|COPYWRITER') && $article = Article::find($request->get('id')))
        {
            $article->content = $request->get('content');
            $article->title = $request->get('title');
            $article->save();

            return $article;
        }

        return [];
    }

    public function delete(string $slug)
    {
        if(Auth::user()->hasPermission('ADMIN') && $article = Article::where('slug', $slug))
        {
            return ["status" => $article->delete()];
        }

        return [];
    }

    public function setImage(Request $request, int $articleId = 0)
    {
        $file = $request->file('file');

        if(!Auth::user()->hasPermission('ADMIN|COPYWRITER'))
        {
            return [];
        }

        $path = Storage::disk('public')->put('photos', $file);
        $path = 'http://localhost:8081'.Storage::url($path);

        if($articleId && $article = Article::find($articleId))
        {
            $article->image = $path;
            $article->save();

            return ["url" => $article->image];
        }

        return ["default" => $path];
    }
}
