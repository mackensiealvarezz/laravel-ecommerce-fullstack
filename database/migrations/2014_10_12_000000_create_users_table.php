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
            $table->integer('sheetId')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('shop_name');
            $table->string('shop_domain');
            $table->string('card_brand');
            $table->string('card_last_four');
            $table->string('billing_plan');
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('trial_starts_at')->nullable();
            $table->boolean('superadmin')->default(false);
            $table->boolean('is_enabled');
            $table->rememberToken();
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
