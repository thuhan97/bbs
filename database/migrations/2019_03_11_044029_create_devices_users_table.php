<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id');
            $table->integer('devices_id');
            $table->string('code')->nullable();
            $table->date('allocate_date')->comment('Ngày cấp')->nullable();
            $table->date('return_date')->comment('Ngày trả')->nullable();
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
        Schema::dropIfExists('devices_users');
    }
}
