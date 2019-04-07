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

Route::get('/tags/all', 'TagController@index')
    ->name('api_getAllTags');

Route::get('/articles/all/{tag?}', 'ArticleController@index')
    ->name('api_getAllArticles');

Route::get('/articles/{slug}', 'ArticleController@show')
    ->name('api_getArticle');

Route::post('/articles', 'ArticleController@store')
    ->middleware('token.authorization')
    ->name('api_storeArticle');

Route::post('/articles/image/{articleId?}', 'ArticleController@setImage')
    ->middleware('token.authorization')
    ->name('api_setArticleImage');

Route::put('/articles', 'ArticleController@update')
    ->middleware('token.authorization')
    ->name('api_updateArticle');

Route::delete('/articles/{slug}', 'ArticleController@delete')
    ->middleware('token.authorization')
    ->name('api_deleteArticle');

Route::get('/comments/{articleId}', 'CommentController@index')
    ->middleware('token.authorization:true')
    ->name('api_getCommentsForArticle');

Route::post('/comments/{articleId}', 'CommentController@store')
    ->middleware('token.authorization')
    ->name('api_storeComment');

Route::put('/comments', 'CommentController@update')
    ->middleware('token.authorization')
    ->name('api_updateComment');

Route::post('/comments/status/{id}', 'CommentController@setStatus')
    ->middleware('token.authorization')
    ->name('api_setCommentStatus');

Route::post('/user/login', 'Auth\LoginController@login')
    ->name('api_logIn');

Route::post('/user/register', 'Auth\RegisterController@register')
    ->name('api_register');

Route::post('/user/reset', 'Auth\ResetPasswordController@resetPasswordAction')
    ->name('api_resetPassword');
