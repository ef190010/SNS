<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id')->nullable();
            $table->unsignedBigInteger('reply_id')->nullable();
            $table->string('body', 200);
            $table->string('image_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('user_id');
            $table->index('post_id');
            $table->index('body');
            $table->index('reply_id');
            
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('post_id')
                ->references('id')->on('posts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('reply_id')
                ->references('id')->on('replies')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
