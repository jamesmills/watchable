<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWatchTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('watch', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('watchable');
            $table->integer('user_id')->unsigned()->index();
            $table->timestamps();

            $table->unique(['watchable_id', 'watchable_type', 'user_id'], 'watch_user_unique');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('watch');
    }
}
