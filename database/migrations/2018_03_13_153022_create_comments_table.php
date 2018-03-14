<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->create('comments', function ($collection) {
            $collection->index('comment_id');
            $collection->index('video_id');
            $collection->index('author_id');
        });

//        Schema::create('comments', function (Blueprint $table) {
//            $table->string('id', 30)->primary();
//            $table->string('video_id', 30)->index();
//            $table->string('author_id', 30)->index();
//            $table->text('text')->nullable();
//            $table->unsignedInteger('likes')->default(0);
//
//            $table->foreign('video_id')
//                ->references('id')
//                ->on('videos')
//                ->onDelete('cascade');
//
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)->dropIfExists('comments');
    }
}