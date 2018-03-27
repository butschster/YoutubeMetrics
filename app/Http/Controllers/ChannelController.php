<?php

namespace App\Http\Controllers;

use App\Entities\Channel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ChannelController extends Controller
{
    /**
     * @param Channel $channel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Channel $channel)
    {
        $videos = $channel->videos()->latest()->paginate(3);

        $this->meta->setTitle($channel->name);

        return view('channel.show', compact('channel', 'videos'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function botsGroupedByCreationDate()
    {
        $cacheKey = md5(__METHOD__);
        $groupedBots = Cache::remember($cacheKey, now()->addHour(), function () {
            return  Channel::onlyBots()->orderBy('created_at')->get()
                ->groupBy(function (Channel $channel) {
                    return $channel->created_at->format('d.m.Y');
                })
                ->sortByDesc(function (Collection $bots) {
                    return $bots->count();
                });
        });

        $max = $groupedBots->first()->count();

        return view('channel.bots_grouped_by_creation_date', compact('groupedBots', 'max'));
    }

    /**
     * @param string $date
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filteredByDateCreation(string $date)
    {
        return view('channel.filtered_by_date_creation', compact('date'));
    }
}
