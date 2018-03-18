<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->string('id', 30)->primary();
            $table->string('video_id', 30)->index();
            $table->string('channel_id', 30)->index();
            $table->text('text')->nullable();
            $table->unsignedInteger('total_likes')->default(0);
            $table->boolean('is_spam')->default(false);

            $table->index(['channel_id', 'is_spam']);

            $table->foreign('video_id')
                ->references('id')
                ->on('videos')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}