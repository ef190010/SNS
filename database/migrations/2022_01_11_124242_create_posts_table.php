<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            /* $table->unsiginedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); */
            $table->string('body', 200);
            $table->string('image_path')->nullable(); 
        
            /* $table->unsiginedBigInteger('category_id');
            $table->unsiginedBigInteger('prefecture_id'); */
            $table->string('keyword_1', 20)->nullable();
            $table->string('keyword_2', 20)->nullable();
            $table->string('keyword_3', 20)->nullable();
            /* $table->unsiginedBigInteger('num_of_reply'); */
            /* この中にresponse関係が入ります */
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
