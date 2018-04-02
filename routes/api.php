<?php

Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');
Route::post('register', 'Auth\RegisterController@register');

Route::get('me/permissions', 'Api\User\ProfileController@permissions')->name('auth.permissions');
Route::get('me', 'Api\User\ProfileController@me')->name('auth.me');

Route::get('channel/{channel}/metrics', 'Api\ChannelMetricsController@index')->name('channel.metrics');
Route::get('channel/{channel}/comments/bots', 'Api\ChannelCommentsController@fromBots')->name('channel.comments.bots');
Route::get('channel/{channel}/comments', 'Api\ChannelCommentsController@index')->name('channel.comments');

Route::get('channel/reported', 'Api\ChannelReportController@index');
Route::get('channel/bots', 'Api\ChannelController@botList')->name('channels.bots');

Route::namespace('Api\Channel')->group(function () {
    Route::get('channels/followed', 'ChannelController@followed')->name('channels.followed');
    Route::get('channel/{channel}/videos', 'ChannelController@videos')->name('channel.videos');
    Route::get('channel/{channel}', 'ChannelController@show')->name('channel.show');
});


Route::post('channel/check', 'Api\ChannelVerificationController@check')->name('channel.check');

Route::get('bots/created/{date}', 'Api\ChannelController@botsFilteredByDateCreation')->middleware('auth');
Route::get('channels/created/{date}', 'Api\ChannelController@filteredByDateCreation')->middleware('auth');

Route::post('channel/report', 'Api\ChannelReportController@store')->name('channel.report');
Route::post('channel/{channel}/moderate', 'Api\ChannelModerationController@moderate')->name('channel.moderate');
Route::get('comment/{comment}/metrics', 'Api\CommentMetricsController@index');

Route::namespace('Api\Video')->group(function () {

    Route::get('videos', 'VideoController@index')->name('videos');
    Route::get('video/{video}', 'VideoController@show')->name('video.show');

});


Route::delete('video/{video}/comments/cache', 'Api\CommentsController@cacheClear')->middleware('auth');
Route::get('video/{video}/metrics', 'Api\VideoMetricsController@index');
Route::get('video/{video}/comments/spam', 'Api\CommentsController@videoSpam');
Route::get('video/{video}/comments', 'Api\CommentsController@video');