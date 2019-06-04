<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumIsseusIdAndColumCommentSuggestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suggestions', function (Blueprint $table) {
            $table->integer('isseus_id')->nullable()->comment('người giải quyết góp ý');
            $table->string('comment')->nullable()->comment('admin phản hồi cho người giải quyết');
            $table->string('isseus_comment')->nullable()->comment('người giải quyết ý kiến phản hồi của người duyệt');
//            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suggestions', function (Blueprint $table) {
            //
        });
    }
}
