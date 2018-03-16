<?php

Auth::routes();

Route::get('/', 'VideoController@index')->name('home');

Route::get('/author/{author}', 'AuthorController@show')->name('video.show');
Route::get('/video/{video}', 'VideoController@show')->name('video.show');
