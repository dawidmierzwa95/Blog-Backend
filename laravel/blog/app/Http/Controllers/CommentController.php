<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(int $articleId) {
        return Comment::where('article_id', $articleId)->get();
    }
}
