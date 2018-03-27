<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChannelBotsController extends Controller
{
    /**
     * @param string $date
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filteredByDateCreation(string $date)
    {
        return view('channel.bots_filtered_by_date_creation', compact('date'));
    }
}
