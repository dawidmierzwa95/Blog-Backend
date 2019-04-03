<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tags/all', 'TagController@index')->name('api_getAllTags');

Route::get('/articles/all/{tag?}', 'ArticleController@index')->name('api_getAllArticles');
Route::get('/articles/{slug}', 'ArticleController@show')->name('api_getArticle');

Route::get('/comments/{articleId}', 'CommentController@index')->name('api_getCommentsForArticle');

Route::post('/user/login', 'Auth\LoginController@login')->name('api_logIn');
