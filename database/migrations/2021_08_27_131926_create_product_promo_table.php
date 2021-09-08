<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_promo', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('code')->nullable();
            $table->string('type')->default('nominal');            
            $table->integer('amount');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('status');
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
        Schema::dropIfExists('product_promo');
    }
}
