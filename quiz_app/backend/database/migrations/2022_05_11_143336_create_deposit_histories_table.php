<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('total_wallet')->default(0)->comment('tong tien trong vi');
            $table->integer('money')->default(0);
            $table->integer('user_sender_id')->nullable()->comment('nguoi nap tien');
            $table->string('phone')->comment('sdt nguoi nap');
            $table->tinyInteger('type')->default(1);
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
        Schema::dropIfExists('deposit_histories');
    }
}
