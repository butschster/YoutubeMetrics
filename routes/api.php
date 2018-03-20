<?php

Route::post('channel/check', 'Api\ChannelController@check');
Route::get('channel/reported', 'Api\ChannelController@reported')->middleware('auth');
Route::get('channel/bots', 'Api\ChannelController@bots');

Route::group(['middleware' => 'throttle:rate_limit|1,1'], function() {
    Route::post('channel/abuse', 'Api\ChannelReportController@store');
    Route::delete('channel/abuse', 'Api\ChannelReportController@destroy');
});

Route::get('channel/{author}/comments', 'Api\CommentsController@channel');

Route::delete('channel/{author}/moderate', 'Api\ChannelModerationController@markAsBot');
Route::post('channel/{author}/moderate', 'Api\ChannelModerationController@markAsNormal');

Route::get('comment/{comment}/metrics', 'Api\CommentMetricsController@index');
Route::get('video/{video}/metrics', 'Api\VideoMetricsController@index');
Route::get('video/{video}/comments', 'Api\CommentsController@index');