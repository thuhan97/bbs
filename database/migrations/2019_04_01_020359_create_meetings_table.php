<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('color', 20)->comment('Màu trên lịch');
            $table->integer('seats')->default(0)->comment('Số ghế');
            $table->text('description')->nullable()->comment('Mô tả phòng');
            $table->text('other')->nullable()->comment('Ghi chú khác');
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
        Schema::dropIfExists('meeting_rooms');
    }
}
