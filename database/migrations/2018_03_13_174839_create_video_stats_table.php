<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoStatsTable extends Migration
{
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->create('video_stats', function ($collection) {
            $collection->index('video_id');
        });

//        Schema::create('video_stats', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('video_id', 30)->index();
//
//            $table->unsignedInteger('views')->default(0);
//            $table->unsignedInteger('likes')->default(0);
//            $table->unsignedInteger('dislikes')->default(0);
//            $table->unsignedInteger('comments')->default(0);
//            $table->unsignedInteger('favorites')->default(0);
//
//            $table->foreign('video_id')
//                ->references('id')
//                ->on('videos')
//                ->onDelete('cascade');
//
//            $table->timestamp('created_at', 0)->nullable();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)->drop('video_stats');
    }
}
