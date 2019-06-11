<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSelectType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_time_registers', function (Blueprint $table) {
            $table->string('select_type')->nullable()->comment('Kiểu chọn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_time_registers', function (Blueprint $table) {
            $table->dropColumn('select_type');
        });
    }
}
