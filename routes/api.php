<?php

Route::post('channel/check', 'Api\ChannelController@check');
Route::post('channel/abuse', 'Api\ChannelReportController@store');
Route::delete('channel/abuse', 'Api\ChannelReportController@destroy');

Route::get('video/{id}/metrics', 'Api\VideoMetricsController@index');
Route::get('video/{id}/comments', 'Api\CommentsController@index');