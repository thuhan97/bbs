<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeEndRemoveColumnToRemainDayoffs extends Migration
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
            $table->dropColumn('previous_year');
            $table->integer('current_year')->default(0)->change();
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
