<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gmail', 191);
            $table->string('gitlab', 191);
            $table->string('chatwork', 191);
            $table->text('skills')->comment('Khả năng hiện tại');
            $table->text('in_future')->comment('Định hướng tương lai');
            $table->string('hobby', 1000)->nullable();
            $table->string('foreign_language', 1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gmail', 'gitlab', 'chatwork', 'skills', 'in_future', 'hobby', 'foreign_language');
        });
    }
}
