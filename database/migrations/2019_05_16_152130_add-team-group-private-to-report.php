<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeamGroupPrivateToReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->integer('group_id')->nullable();
            $table->integer('team_id')->nullable();
            $table->date('report_date')->nullable();
            $table->tinyInteger('is_private')->default(0)->comment('0: toàn công ty; 1: nội bộ team;')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
