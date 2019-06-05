<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('meeting_id')->nullable();
            $table->integer('meeting_room_id')->unsigned();
            $table->integer('users_id')->unsigned();
            $table->string('participants');
            $table->string('title');
            $table->text('content');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->tinyInteger('repeat_type');
            $table->string('days_repeat');
            $table->string('color');
            $table->tinyInteger('is_notify');
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
        Schema::dropIfExists('recurs');
    }
}
