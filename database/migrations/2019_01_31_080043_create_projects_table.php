<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->unique();
            $table->string('customer')->nullable();
            $table->tinyInteger('project_type')->default(0)->comment('0:ODC; 1: Trọn gói ');
            $table->integer('scale')->nullable()->comment('man/month');
            $table->string('amount_of_time')->nullable()->comment('month');
            $table->string('technical')->nullable();
            $table->string('tools')->nullable();
            $table->unsignedInteger('leader_id')->nullable();
            $table->text('description')->nullable();
            $table->date('start_date')->nullable()->comment('Ngày bắt đầu ');
            $table->date('end_date')->nullable()->comment('Ngày kết thúc');
            $table->string('image_url')->nullable(); 
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('leader_id')->references('id')->on('users');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
