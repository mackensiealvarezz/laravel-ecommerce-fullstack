<?php

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('sheetId')->nullable();
            $table->foreignIdFor(Product::class, 'product_id')->index();
            $table->foreignIdFor(Inventory::class, 'inventory_id')->index();
            $table->text('street_address');
            $table->text('apartment')->nullable();
            $table->text('city')->nullable();
            $table->text('state');
            $table->text('country_code');
            $table->text('zip');
            $table->text('email');
            $table->string('name');
            $table->string('order_status');
            $table->text('payment_ref')->nullable();
            $table->string('transaction_id')->nullable();
            $table->integer('payment_amt_cents');
            $table->integer('ship_charged_cents')->nullable();
            $table->integer('ship_cost_cents')->nullable();
            $table->integer('subtotal_cents');
            $table->integer('total_cents');
            $table->text('shipper_name');
            $table->timestamp('payment_date')->nullable();
            $table->timestamp('shipped_date')->nullable();
            $table->text('tracking_number');
            $table->integer('tax_total_cents');
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
        Schema::dropIfExists('orders');
    }
}
