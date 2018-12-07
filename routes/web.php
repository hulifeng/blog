<?php
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::resource('/articles', 'ArticlesController');

Route::group(['middleware' => ['auth', 'super'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index')->name('admin.index');
});

Route::group(['namespace' => 'Smartmd', 'prefix' => 'editor'], function () {
    Route::post('/upload', 'UploadController@imSave');
    Route::get('/write', function () {
        return view('vendor/smartmd/write');
    });
    Route::get('/php-show','ParseController@index');
    Route::get('/js-show',function(){
        return view('vendor/smartmd/js-show');
    });
});
