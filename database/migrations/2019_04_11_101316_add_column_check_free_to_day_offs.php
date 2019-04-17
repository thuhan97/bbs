<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCheckFreeToDayOffs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('day_offs', function (Blueprint $table) {
            $table->tinyInteger('check_free')->default(0)->comment('nếu là nữ check xem còn ngày nghỉ free hay không');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('day_offs', function (Blueprint $table) {
            //
        });
    }
}
