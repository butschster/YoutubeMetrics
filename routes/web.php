<?php

Auth::routes();

Route::get('/', 'VideoController@index')->name('home');

Route::get('/video/{video}', 'VideoController@show')->name('video.show');
