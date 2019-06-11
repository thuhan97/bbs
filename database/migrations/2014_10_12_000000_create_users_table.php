<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('staff_code', 10)->unique();
            $table->string('name');
            $table->string('phone', 30)->unique();
            $table->string('email', 191)->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('id_card')->nullable()->comment('Chứng minh nhân dân');
            $table->string('id_addr')->nullable()->comment('Nơi cấp');
            $table->string('address')->nullable()->comment('Địa chỉ thường trú');
            $table->string('current_address')->nullable()->comment('Chỗ ở hiện tại');
            $table->string('school')->nullable()->comment('Đại học/Cao Đẳng');
            $table->date('birthday')->nullable();
            $table->date('start_date')->nullable()->comment('Ngày bắt đầu làm việc');
            $table->date('end_date')->nullable()->comment('Ngày nghỉ việc');

            $table->tinyInteger('contract_type')->default(0)->comment('0: Chính thức; 1: Thử việc; 2: Partime; 3: Thực tập ');
            $table->tinyInteger('status')->default(0);

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
