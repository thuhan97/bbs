<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ot_times', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('work_time_id');
            $table->integer('creator_id')->comment('Người tạo đề xuất');
            $table->integer('minute')->default(0)->comment('Số phút OT');
            $table->string('reason', 1000);
            $table->tinyInteger('status')->comment('0: Chưa duyệt; 1: Đã duyệt');

            $table->integer('approver_id')->nullable()->comment('Người duyệt');
            $table->timestamp('approver_at')->nullable()->comment('Phê duyệt lúc');

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
        Schema::dropIfExists('ot_times');
    }
}
