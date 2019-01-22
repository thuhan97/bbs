<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDayOff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_offs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('leave_id')->nullable();
            $table->string('title');
            $table->string('reason', 1000);
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->decimal('number_off', 2, 1)->comment('Số ngày nghỉ phép (cho phép nghỉ nửa ngày)');

            $table->tinyInteger('status')->comment('0: Chưa duyệt; 1: Đã duyệt');

            $table->integer('approver_id')->nullable()->comment('Người duyệt');
            $table->timestamp('approver_at')->nullable()->comment('Phê duyệt lúc');

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
        Schema::dropIfExists('day_offs');
    }
}
