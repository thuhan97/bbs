<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeLateEarlyAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configs', function (Blueprint $table) {
            $table->time('time_morning_go_late_at')->nullable();
            $table->time('time_afternoon_go_late_at')->nullable();
            $table->time('time_ot_early_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configs', function (Blueprint $table) {
            $table->dropColumn('time_morning_go_late_at', 'time_afternoon_go_late_at', 'time_ot_early_at');
        });
    }
}
