<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStartAtToOtTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ot_times', function (Blueprint $table) {
            $table->string('project_name',255);
            $table->integer('ot_type')->comment('1: OT dự án / 2: OT lý do cá nhân');
            $table->time('start_at');
            $table->time('end_at');
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
