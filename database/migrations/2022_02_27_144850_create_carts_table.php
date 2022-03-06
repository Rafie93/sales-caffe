<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id');
            $table->integer('product_id');
            $table->integer('price')->default(0);
            $table->integer('price_item')->default(0);
            $table->integer('price_promo')->default(0);
            $table->integer('price_variant')->default(0);
            $table->integer('qty')->default(1);
            $table->integer('subtotal');
            $table->longText('product_variant')->nullable();
            $table->string('notes');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('carts');
    }
}
