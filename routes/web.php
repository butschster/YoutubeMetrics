<?php

Route::get('/channels/created/{date}', 'ChannelController@filteredByDateCreation')->name('channel.created.date')->middleware('auth');

Route::get('/bots/created/{date}', 'ChannelBotsController@filteredByDateCreation')->name('channel.bots.date');
Route::get('/bots/grouped-by-date', 'ChannelController@botsGroupedByCreationDate')->name('channel.bots');

Route::get('/comments/spam', 'CommentsController@spamToday')->name('comments.spam');