<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type')->comment('0: Mua mới; 1: Thanh lý;');
            $table->integer('types_device_id')->comment('0: Case; 1: Màn hình; 2: Chuột; 3: Bàn phím; 4: Điện thoại; 5: Máy tính bảng; 6: Khác ');
            $table->text('detail')->nullable();
            $table->text('note')->comment('Ghi chú')->nullable();
            $table->date('deadline_at')->nullable();

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
        Schema::dropIfExists('actions_devices');
    }
}
