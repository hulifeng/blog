<?php
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::resource('/articles', 'ArticlesController');

// 文章置顶
Route::get('/articles/{article}/top', 'ArticlesController@top')->name('articles.top');

// 文章发布
Route::get('/articles/{article}/release', 'ArticlesController@release')->name('articles.release');

// 文章评论
Route::resource('comments', 'CommentsController', ['only' => ['store', 'destroy']]);

// 游客点赞
Route::post('/articles/{article}/like', 'ArticlesController@like')->name('articles.like');
// 游客取消点赞
Route::delete('/articles/{article}/unlike', 'ArticlesController@unlike')->name('articles.unlike');

Route::group(['middleware' => ['auth', 'super'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index')->name('admin.index');
});

Route::get('/categories/{category}', 'CategoriesController@show')->name('categories.show');
