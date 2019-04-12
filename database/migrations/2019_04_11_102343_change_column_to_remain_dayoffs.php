<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnToRemainDayoffs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remain_dayoffs', function (Blueprint $table) {

            $table->renameColumn('current_year', 'year');
            $table->integer('current_year')->default(0)->change();
            $table->renameColumn('previous_year', 'remain');
            $table->integer('previous_year')->default(0)->change();
            $table->integer("active")->default(1)->comment('tính số ngày nghỉ theo tháng tăng lên theo từng tháng');
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
