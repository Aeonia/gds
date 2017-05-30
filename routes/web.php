<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('root');

Auth::routes();

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('root');
});

Route::get(
    '/home',
    'HomeController@index'
)->name('home');

Route::post(
    '/articles/{article_id}/comments',
    'CommentController@store'
)->name('comments.store');
Route::delete(
    '/articles/{article_id}/comments/{comment_id}',
    'CommentController@destroy'
)->name('comments.destroy');

Route::put(
    '/articles/{article_id}/votes',
    'VoteController@update'
)->name('votes.update');

Route::get(
    '/articles/{article_id}/publish',
    'ArticleController@publish'
)->name('articles.publish');
Route::get(
    '/articles/{article_id}/unpublish',
    'ArticleController@unpublish'
)->name('articles.unpublish');

Route::resource(
    'articles',
    'ArticleController'
);

Route::put(
    '/users/{user_id}/upgrade',
    'UserController@upgrade'
)->name('users.upgrade');
Route::resource(
    'users',
    'UserController',
    ['only' => ['index', 'show', 'edit', 'update']]
);

Route::resource(
    'issues',
    'IssueController',
    ['only' => ['index', 'show', 'edit', 'update']]
);
