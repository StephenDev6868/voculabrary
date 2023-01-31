<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplyFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reply_feedback', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('title')->nullable();
            $table->text('content')->nullable();
            $table->integer('feedback_id');
            $table->timestamps();
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->tinyInteger('reply')->nullable()->comment('1 da reply');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reply_feedback');
    }
}
