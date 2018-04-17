<?php
Route::namespace('Auth')->group(function () {
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout');
    Route::post('register', 'RegisterController@register')->name('auth.register');
});

Route::namespace('User')->group(function () {
    Route::get('me/permissions', 'GetPermissions')->name('auth.permissions');
    Route::get('me', 'GetProfile')->name('auth.me');
});

Route::namespace('Channel')->group(function () {
    Route::get('channel/{channel}/reporters', 'CetReporters')->name('channel.reporters');
    Route::get('channel/{channel}/metrics', 'GetMetrics')->name('channel.metrics');
    Route::get('channel/{channel}/comments/spam', 'GetSpamComments')->name('channel.comments.spam');
    Route::get('channel/{channel}/comments', 'GetComments')->name('channel.comments');

    Route::get('channel/reported', 'GetReportedChannels')->name('channels.reported');
    Route::get('channel/bots', 'GetBotChannels')->name('channels.bots');

    Route::get('channels/followed', 'GetFollowingChannels')->name('channels.followed');
    Route::get('channel/{channel}/videos', 'GetChannelVideos')->name('channel.videos');
    Route::get('channel/{channel}', 'Show')->name('channel.show');

    Route::post('channel/check', 'CheckChannel')->name('channel.check');

    Route::get('channels/created/{date}', 'GetChannelsFilteredByDateCreation');

    Route::post('channel/report', 'SendReportToChannel')->name('channel.report');
    Route::post('channel/{channel}/moderate', 'ModerateChannel')->name('channel.moderate');

    Route::get('bots/created/{date}', 'GetBotChannelsFilteredByDateCreation');
    Route::get('bots/grouped-by-date', 'GetBotChannelsGroupedByCreationDate')->name('channel.bots');
});

Route::namespace('Comment')->group(function () {
    Route::get('comment/{comment}/metrics', 'GetMetrics')->name('comment.metrics');
    Route::get('comment/{comment}', 'Show')->name('comment.show');
});

Route::namespace('Video')->group(function () {
    Route::get('videos', 'GetList')->name('videos');
    Route::get('video/{video}/comments/spam', 'GetSpamComments')->name('video.comments.spam');
    Route::get('video/{video}/comments', 'GetComments')->name('video.comments');
    Route::get('video/{video}/metrics', 'GetMetrics')->name('video.metrics');
    Route::get('video/{video}/tags', 'GetTags')->name('video.tags');
    Route::get('video/{video}', 'Show')->name('video.show');

    Route::delete('video/{video}/comments/cache', 'ClearCommentsCache');
});

Route::namespace('Tag')->group(function () {
    Route::get('tag/{tag}/videos', 'GetVideos')->name('tag.videos');
    Route::get('tag/{tag}', 'Show')->name('tag.show');
});