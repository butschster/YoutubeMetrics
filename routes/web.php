<?php

Auth::routes();

Route::get('/', 'VideoController@index')->name('home');

Route::get('/channel/moderate', 'ChannelModerationController@index')->name('channel.moderate');
Route::get('/channel/{author}', 'ChannelController@show')->name('channel.show');
Route::get('/video/{video}', 'VideoController@show')->name('video.show');

Route::get('/comments/spam', 'CommentsController@spamToday')->name('comments.spam');
Route::get('/comment/{comment}', 'CommentsController@show')->name('comment.show');