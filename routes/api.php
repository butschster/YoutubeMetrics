<?php

Route::post('channel/check', 'Api\ChannelController@check');
Route::post('channel/abuse', 'Api\ChannelReportController@store');
Route::delete('channel/abuse', 'Api\ChannelReportController@destroy');

Route::get('comment/{comment}/metrics', 'Api\CommentMetricsController@index');
Route::get('video/{video}/metrics', 'Api\VideoMetricsController@index');
Route::get('video/{video}/comments', 'Api\CommentsController@index');
Route::get('author/{author}/comments', 'Api\CommentsController@author');