<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateCommentsFromMongoDBToMysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comments:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->confirm("Вы уверены что хотите запустить миграцию комментариев?");

        DB::table('comments')->truncate();

        DB::connection('mongodb')->table('comments')->orderBy('create_at')->chunk(100, function ($comments) {
            $query = DB::table('comments');
            $values = [];

            foreach ($comments as $comment) {
                if (DB::table('comments')->where('id', $comment['comment_id'])->exists()) {
                    continue;
                }

                $values[$comment['comment_id']] = [
                    'id' => $comment['comment_id'],
                    'channel_id' => $comment['author_id'],
                    'video_id' => $comment['video_id'],
                    'text' => $comment['text'],
                    'created_at' => Carbon::createFromTimestamp($comment['created_at']->toDateTime()->getTimestamp()),
                    'total_likes' => $comment['total_likes'],
                    'is_spam' => $comment['span'] ?? false
                ];
            }

            $query->insert($values);

        });
    }
}
