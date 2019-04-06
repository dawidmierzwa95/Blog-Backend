<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class ArticleController extends Controller
{
    public function index(string $tag = "") {
        return Article::all();
    }

    public function show(string $slug) {
        return Article::where('slug', $slug)->first();
    }

    public function store(Request $request) {

    }

    public function update(Request $request, string $slug) {

    }

    public function delete(string $slug) {
        if($item = Article::where('slug', $slug)) {
            $item->delete();
        }
    }
}
