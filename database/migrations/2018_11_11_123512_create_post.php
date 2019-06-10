<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('creator_id');
            $table->string('name');
            $table->string('slug_name');
            $table->string('tags')->nullable();
            $table->string('author_name')->nullable();
            $table->string('image_url', 500);
            $table->string('introduction', 500);
            $table->longText('content');
            $table->integer('view_count')->default(0);
            $table->tinyInteger('status');

            $table->tinyInteger('has_notify')->default(0);
            $table->dateTime('notify_date')->nullable();

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
        Schema::dropIfExists('posts');
    }
}
