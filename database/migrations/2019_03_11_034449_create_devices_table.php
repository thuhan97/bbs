<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('types_device_id')->comment('0: Case; 1: Màn hình; 2: Chuột; 3: Bàn phím; 4: Điện thoại; 5: Máy tính bảng; 6: Khác ');
            $table->string('name');
            $table->integer('quantity_inventory')->comment('Số lượng tồn')->default(0)->nullable();
            $table->integer('quantity_used')->comment('Số lượng đang sử dụng')->default(0)->nullable();
            $table->integer('quantity_unused')->comment('Số lượng chưa sử dụng')->default(0)->nullable();
            $table->integer('month_of_use')->comment('Tháng sử dụng')->default(0)->nullable();
            $table->integer('final')->comment('Tồn cuối')->default(0)->nullable();
            $table->text('note')->comment('Ghi chú')->nullable();

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
        Schema::dropIfExists('devices');
    }
}
