<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentLikesTable extends Migration
{
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->create('comment_likes', function ($collection) {
            $collection->index('comment_id');
        });

//        Schema::create('comment_likes', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('comment_id')->index();
//            $table->unsignedInteger('count')->default(0);
//
//            $table->foreign('comment_id')
//                ->references('id')
//                ->on('comments')
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
        Schema::connection($this->connection)->dropIfExists('comment_likes');
    }
}
