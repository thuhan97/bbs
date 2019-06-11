<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtTypeToWorkTimesExplanationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_times_explanation', function (Blueprint $table) {
            $table->integer('ot_type')->nullable()->comment('1: OT dự án / 2: OT lý do cá nhân');
            $table->integer('type')->change()->comment('0: Bình thường / 1: Đi muộn / 2: Về sớm / 4: Overtime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_times_explanation', function (Blueprint $table) {
            //
        });
    }
}
