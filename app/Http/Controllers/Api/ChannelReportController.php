<?php

namespace App\Http\Controllers\Api;

use App\Entities\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ChannelReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $request->validate(['channel_id' => 'required']);

        $channel = Channel::firstOrNew(['id' => $request->channel_id]);
        $this->authorize('report', $channel);

        $channel->sendReport();

        $this->clearCache($channel);

        return ['type' => $channel->type];
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request)
    {
        $request->validate(['channel_id' => 'required']);

        $channel = Channel::firstOrNew(['id' => $request->channel_id]);
        $this->authorize('report', $channel);

        $channel->updateReports(-1);

        $this->clearCache($channel);

        return ['type' => $channel->type];
    }

    /**
     * @param Channel $channel
     */
    protected function clearCache(Channel $channel): void
    {
        Cache::forget(md5('channel'.$channel->id));
    }
}
