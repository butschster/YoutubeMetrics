<?php

Auth::routes();

Route::get('/', 'VideoController@index')->name('home');

Route::get('/channels/moderate', 'ChannelModerationController@index')->name('channel.moderate');
Route::get('/channel/{channel}', 'ChannelController@show')->name('channel.show');

Route::get('/tag/{tag}', 'TagsController@show')->name('tag.show');
Route::get('/video/{video}', 'VideoController@show')->name('video.show');

Route::get('/comments/spam', 'CommentsController@spamToday')->name('comments.spam');

// Route::get('/comment/{comment}/image', 'CommentsController@image')->name('comment.image');
Route::get('/comment/{comment}', 'CommentsController@show')->name('comment.show');