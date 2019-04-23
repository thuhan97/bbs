<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePunishTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('punishes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rule_id');
            $table->integer('user_id');
            $table->date('infringe_date');
            $table->integer('total_money')->default(0);
            $table->string('detail')->nullable();
            $table->tinyInteger('is_submit')->default(0)->comment('0: Mới tạo; 1: đã nộp');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('punishes');
    }
}
