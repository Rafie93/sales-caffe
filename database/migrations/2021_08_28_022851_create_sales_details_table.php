<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_details', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id');
            $table->integer('sale_id');
            $table->integer('product_id');
            $table->integer('price');
            $table->integer('price_promo')->default(0);
            $table->integer('price_variant')->default(0);
            $table->integer('qty');
            $table->integer('subtotal');
            $table->string('notes')->nullable();
            $table->integer('rating')->nullable();
            $table->string('ulasan')->nullable();
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
        Schema::dropIfExists('order_details');
    }
}
