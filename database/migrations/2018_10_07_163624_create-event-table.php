<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug_name');
            $table->string('image_url', 1000);
            $table->date('event_date');
            $table->date('event_end_date')->nullable();
            $table->string('place');
            $table->string('introduction', 500);
            $table->longText('content');

            $table->integer('view_count')->default(0);
            $table->tinyInteger('status');

            $table->tinyInteger('has_notify')->default(0);
            $table->string('user_levels')->nullable();
            $table->dateTime('notify_date')->nullable();

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
        Schema::dropIfExists('events');
    }
}
