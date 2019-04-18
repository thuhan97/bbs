<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recurs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('meetings_id')->unsigned();
            $table->integer('users_id')->unsigned();
            $table->string('participants');
            $table->string('title');
            $table->text('content');
            $table->tinyInteger('is_notify');
            $table->time('start_time');
            $table->time('end_time');
            $table->tinyInteger('repeat_type');
            $table->string('days_repeat');
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
        Schema::dropIfExists('recurs');
    }
}
