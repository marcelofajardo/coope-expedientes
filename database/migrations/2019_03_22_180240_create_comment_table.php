<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
             $table->increments('id');
             $table->text('content');
             $table->integer('parent_id')->unsigned()->nullable();
             $table->integer('anexo_id')->unsigned();
             $table->integer('user_id')->unsigned();
             $table->timestamps();

             $table->foreign('parent_id')->references('id')->on('comment');
             $table->foreign('anexo_id')->references('id')->on('anexo');
             $table->foreign('user_id')->references('id')->on('users');
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
