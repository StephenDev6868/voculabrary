<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnResetHeartToUserSuggestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_suggestions', function (Blueprint $table) {
            $table->tinyInteger('reset_suggest')->nullable()->comment('1: reset');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_suggestions', function (Blueprint $table) {
            $table->dropColumn('reset_suggest');
        });
    }
}
