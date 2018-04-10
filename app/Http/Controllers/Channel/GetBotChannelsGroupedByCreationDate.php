<?php

namespace App\Http\Controllers\Channel;

use App\Entities\Channel;
use App\Http\Controllers\Controller;
use App\Http\Resources\Channel\ChannelResource;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class GetBotChannelsGroupedByCreationDate extends Controller
{
    public function __invoke()
    {
        $groupedBots = Cache::remember(__CLASS__, now()->addHour(), function () {
            return  Channel::onlyBots()->orderBy('created_at')->get()
                ->map(function (Channel $channel) {
                    return new ChannelResource($channel);
                })
                ->groupBy(function ($channel) {
                    return Carbon::parse($channel->created_at)->format('d.m.Y');
                })
                ->sortByDesc(function (Collection $bots) {
                    return $bots->count();
                })->toArray();
        });

        return [
            'bots' => $groupedBots
        ];
    }
}