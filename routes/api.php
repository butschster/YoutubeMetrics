<?php

Route::get('channels/followed', 'Api\ChannelController@followed');

Route::get('channel/reported', 'Api\ChannelReportController@index');
Route::post('channel/check', 'Api\ChannelVerificationController@check');


Route::get('channel/bots', 'Api\ChannelController@botList')->name('channels.bots');

Route::get('channel/{channel}/metrics', 'Api\ChannelMetricsController@index');

Route::get('channel/{channel}/comments/bots', 'Api\ChannelCommentsController@fromBots');
Route::get('channel/{channel}/comments', 'Api\ChannelCommentsController@index');

Route::post('channel/abuse', 'Api\ChannelReportController@store')->name('channel.abuse');

Route::delete('channel/{channel}/moderate', 'Api\ChannelModerationController@markAsBot');
Route::post('channel/{channel}/moderate', 'Api\ChannelModerationController@markAsNormal');

Route::get('comment/{comment}/metrics', 'Api\CommentMetricsController@index');

Route::delete('video/{video}/comments/cache', 'Api\CommentsController@cacheClear')->middleware('auth');
Route::get('video/{video}/metrics', 'Api\VideoMetricsController@index');
Route::get('video/{video}/comments/spam', 'Api\CommentsController@videoSpam');
Route::get('video/{video}/comments', 'Api\CommentsController@video');