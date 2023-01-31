<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('alias')->nullable();
            $table->string('file')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('suggest_number')->nullable();
            $table->integer('priority')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:active, 2:inActive');
            $table->integer('user_id');
            $table->text('answer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams');
    }
}
