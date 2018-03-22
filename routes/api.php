<?php

Route::get('channels/followed', 'Api\ChannelController@followed');
Route::post('channel/check', 'Api\ChannelController@check');
Route::get('channel/reported', 'Api\ChannelController@reported')->middleware('auth');
Route::get('channel/bots', 'Api\ChannelController@bots');
Route::get('channel/{channel}/metrics', 'Api\ChannelMetricsController@index');

Route::get('channel/{channel}/comments/bots', 'Api\ChannelCommentsController@fromBots');
Route::get('channel/{channel}/comments', 'Api\ChannelCommentsController@index');

Route::post('channel/abuse', 'Api\ChannelReportController@store');
Route::delete('channel/abuse', 'Api\ChannelReportController@destroy');



Route::delete('channel/{channel}/moderate', 'Api\ChannelModerationController@markAsBot');
Route::post('channel/{channel}/moderate', 'Api\ChannelModerationController@markAsNormal');

Route::get('comment/{comment}/metrics', 'Api\CommentMetricsController@index');
Route::get('video/{video}/metrics', 'Api\VideoMetricsController@index');
Route::get('video/{video}/comments/spam', 'Api\CommentsController@videoSpam');
Route::get('video/{video}/comments', 'Api\CommentsController@video');