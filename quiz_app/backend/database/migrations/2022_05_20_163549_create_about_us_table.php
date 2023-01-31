<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('alias')->nullable();
            $table->string('logo')->nullable();
            $table->text('content')->nullable();
            $table->string('app_version')->nullable();
            $table->tinyInteger('type')->default(1)->comment('1:about us, 2:policy');
            $table->tinyInteger('status')->default(1)->comment('1:active, 2:inActive');
            $table->integer('user_id');
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
        Schema::dropIfExists('about_us');
    }
}
