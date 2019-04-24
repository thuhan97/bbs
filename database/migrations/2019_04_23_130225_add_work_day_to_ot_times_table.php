<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWorkDayToOtTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ot_times', function (Blueprint $table) {
            $table->date('work_day');
            $table->integer('work_time_id')->nullable()->change();
            $table->integer('minute')->nullable()->change();
            $table->string('reason',255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ot_times', function (Blueprint $table) {
            //
        });
    }
}
