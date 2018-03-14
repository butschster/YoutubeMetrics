<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->timestamps();
        });

        Schema::create('tag_video', function (Blueprint $table) {
            $table->unsignedInteger('tag_id');
            $table->string('video_id');

            $table->primary(['tag_id', 'video_id']);

            $table->foreign('video_id')
                ->references('id')
                ->on('videos')
                ->onDelete('cascade');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tag_video', function (Blueprint $table) {
            $table->dropForeign(['tag_id']);
            $table->dropForeign(['video_id']);
        });

        Schema::dropIfExists('tag_video');
        Schema::dropIfExists('tags');
    }
}
