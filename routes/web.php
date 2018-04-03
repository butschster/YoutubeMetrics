<?php

Route::get('/', 'VideoController@index')->name('home');

Route::get('/channels/created/{date}', 'ChannelController@filteredByDateCreation')->name('channel.created.date')->middleware('auth');

Route::get('/bots/created/{date}', 'ChannelBotsController@filteredByDateCreation')->name('channel.bots.date');
Route::get('/bots/grouped-by-date', 'ChannelController@botsGroupedByCreationDate')->name('channel.bots');

Route::get('/channels/moderate', 'ChannelModerationController@index')->name('channel.moderation');
Route::get('/channel/{channel}', 'ChannelController@show')->name('channel.show');

Route::get('/video/{video}', 'VideoController@show')->name('video.show');

Route::get('/comments/spam', 'CommentsController@spamToday')->name('comments.spam');

// Route::get('/comment/{comment}/image', 'CommentsController@image')->name('comment.image');
Route::get('/comment/{comment}', 'CommentsController@show')->name('comment.show');