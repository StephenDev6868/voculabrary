<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('phone', 12)->nullable();
            $table->text('fullname')->nullable();
            $table->string('avatar')->nullable();
            $table->string('avatar_type')->default('gravatar');
            $table->integer('role_id')->default(2)->comment('1: admin, 2: Guest');
            $table->integer('wallet')->default(0);
            $table->text('address')->nullable();
            $table->date('date_or_birth')->nullable();
            $table->tinyInteger('gender')->default(1);
            $table->tinyInteger('status')->default(1)->comment('1: active, 2: inactive');
            $table->string('social_id')->nullable();
            $table->tinyInteger('online')->nullable()->comment('1:online, 2:offline');
            $table->tinyInteger('social_type')->nullable()->comment('null: thuong, 1: google, 2:facebook, 3:guest');
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
