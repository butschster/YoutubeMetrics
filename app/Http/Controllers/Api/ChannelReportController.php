<?php

namespace App\Http\Controllers\Api;

use App\Entities\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        $author = Author::firstOrNew(['id' => $request->channel_id]);
        $this->authorize('report', $author);

        $author->sendReport();

        return ['type' => $author->type()];
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request)
    {
        $request->validate(['channel_id' => 'required']);

        $author = Author::firstOrNew(['id' => $request->channel_id]);
        $this->authorize('report', $author);

        $author->updateReports(-1);

        return ['type' => $author->type()];
    }
}
