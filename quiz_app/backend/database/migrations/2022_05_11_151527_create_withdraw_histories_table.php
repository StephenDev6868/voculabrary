<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('total_wallet')->default(0)->comment('tong tien trong vi');
            $table->integer('money')->default(0);
            $table->integer('receive_user_id')->nullable()->comment('nguoi nhan');
            $table->string('phone')->comment('sdt nguoi nhan');
            $table->tinyInteger('type')->default(2);
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
        Schema::dropIfExists('withdraw_histories');
    }
}
