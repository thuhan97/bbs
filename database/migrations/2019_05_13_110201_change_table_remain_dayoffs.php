<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableRemainDayoffs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remain_dayoffs', function (Blueprint $table) {
            $table->decimal('remain', 3, 1)->default(0)->comment('số ngày nghỉ phép trong năm')->change();
            $table->decimal('remain_pre_year', 3, 1)->default(0)->comment('số ngày nghỉ phép năm ngoái chuyển sang')->change();
            $table->decimal('day_off_free_female', 2, 1)->default(0)->comment('cộng hàng tháng 1 ngày đối với nữ');
            $table->integer('check_add_free')->default(0)->comment('0 là chưa được cộng trong tháng đó , 1 là đã được cộng trong tháng đó ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('remain_dayoffs', function (Blueprint $table) {
            //
        });
    }
}
