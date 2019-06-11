<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configs', function (Blueprint $table) {
            $table->dropColumn('start_work_at', 'end_work_at');

            $table->time('morning_start_work_at')->nullable();
            $table->time('morning_end_work_at')->nullable();
            $table->time('afternoon_start_work_at')->nullable();
            $table->time('afternoon_end_work_at')->nullable();

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
