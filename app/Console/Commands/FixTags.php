<?php

namespace App\Console\Commands;

use App\Entities\Tag;
use DB;
use Illuminate\Console\Command;

class FixTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tags:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tags = Tag::get(['id', 'name'])
            ->groupBy('name')
            ->each(function ($tags, $name) {
                $ids = $tags->pluck('id');
                $primaryId = $ids->shift();

                foreach ($ids as $id) {
                    $links = DB::table('tag_video')->where('tag_id', $id)->get();

                    foreach ($links as $link) {
                        if (DB::table('tag_video')->where('tag_id', $primaryId)->where('video_id', $link->video_id)->exists()) {
                            DB::table('tag_video')->where('tag_id', $link->tag_id)->where('video_id', $link->video_id)->delete();
                        } else {
                            DB::table('tag_video')->where('tag_id', $link->tag_id)->where('video_id', $link->video_id)->update([
                                'tag_id' => $primaryId
                            ]);
                        }

                    }
                }


                Tag::whereIn('id', $ids)->delete();
            });
    }
}
