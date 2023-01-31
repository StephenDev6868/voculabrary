<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias')->nullable();
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('banner')->nullable();
            NestedSet::columns($table);
            $table->tinyInteger('type')->nullable()->default(1)->comment('1: product, 2: article');
            $table->tinyInteger('status')->default(1)->comment('1:active, 2:inActive');
            $table->tinyInteger('show_icon')->nullable()->comment('1:active, null:inActive');
            $table->tinyInteger('show_banner')->nullable()->comment('1:active, null:inActive');
            $table->integer('user_id')->nullable()->index();
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
        Schema::dropIfExists('categories');
    }
}
