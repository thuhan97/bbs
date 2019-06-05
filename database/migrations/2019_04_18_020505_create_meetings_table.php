<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('meeting_room_id')->unsigned();
            $table->integer('users_id')->unsigned();
            $table->string('paticipants');
            $table->string('title');
            $table->text('content');
            $table->tinyInteger('is_notify');
            $table->datetime('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('color');
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
        Schema::dropIfExists('bookings');
    }
}
