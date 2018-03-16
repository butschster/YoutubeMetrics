<?php

Auth::routes();

Route::get('/', 'VideoController@index')->name('home');

Route::get('/author/{id}', 'AuthorController@show')->name('author.show');
Route::get('/video/{video}', 'VideoController@show')->name('video.show');

Route::get('/comments', 'CommentsController@spamToday')->name('comments.spam');