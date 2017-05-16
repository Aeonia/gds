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

Route::get('/home', 'HomeController@index')->name('home');

Route::resource(
    'articles',
    'ArticleController'
);
Route::resource(
    'users',
    'UserController',
    ['only' => ['index', 'show']]
);
Route::resource(
    'issues',
    'IssueController',
    ['only' => ['index', 'show']]
);
