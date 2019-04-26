<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRemainIncrementTableRemianDayoffs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remain_dayoffs', function (Blueprint $table) {
            $table->integer('remain_increment')->nullable()->comment('ngày nghỉ tồn năm ngoái');
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
