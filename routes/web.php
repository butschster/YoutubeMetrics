<?php

Route::get('/channels/created/{date}', 'ChannelController@filteredByDateCreation')->name('channel.created.date')->middleware('auth');

Route::get('/bots/created/{date}', 'ChannelBotsController@filteredByDateCreation')->name('channel.bots.date');

Route::get('/comments/spam', 'CommentsController@spamToday')->name('comments.spam');