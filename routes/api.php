<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('bots', function () {
    return Cache::remember('bots', now()->addHour(), function () {
        return App\Entities\Bot::live()->pluck('id');
    });
});


Route::post('channel/check', function (Request $request) {
    $request->validate([
        'channel_id' => 'required'
    ]);

    $id = $request->channel_id;

    $author = Cache::remember('author:'.$id, now()->addHour(), function () use($id) {
        return App\Entities\Author::live()->find($id);
    });

    return [
        'type' => !is_null($author)
            ? $author->type()
            : 'normal'
    ];
});

Route::post('channel/abuse', function (Request $request) {
    $request->validate([
        'channel_id' => ['required', \Illuminate\Validation\Rule::unique('bots', 'id')]
    ]);

    $author = App\Entities\Author::firstOrNew([
        'id' => $request->channel_id,
    ], [
        'reports' => 0
    ]);

    $author->reports++;
    $author->save();

    return [
        'type' => !is_null($author)
            ? $author->type()
            : 'normal'
    ];
});