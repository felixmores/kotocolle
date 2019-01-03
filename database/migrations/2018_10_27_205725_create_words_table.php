<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('words', function (Blueprint $table) {
            $table->increments('id');
            $table->string('word');
            $table->index('word');
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->smallInteger('lank')->default(0);
            $table->index('lank');
            $table->text('memo')->nullable();
            $table->string('word_image')->nullable();
            $table->smallInteger('share_flag')->default(0);
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
        Schema::dropIfExists('words');
    }
}
