<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('sheetId')->nullable();
            $table->foreignIdFor(User::class, 'admin_id')->index();
            $table->string('name');
            $table->text('description');
            $table->text('style');
            $table->text('brand')->nullable();
            $table->string('type');
            $table->string('url')->nullable();
            $table->integer('shipping_price');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('products');
    }
}
