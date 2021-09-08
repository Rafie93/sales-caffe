<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->integer('store_id')->index();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('cover')->nullable();
            $table->integer('cost_of_goods');
            $table->integer('price_sales');
            $table->integer('is_ready')->default(1);
            $table->integer('is_show_menu')->default(1);
            $table->integer('is_ppn')->default(0);
            $table->integer('status')->default(1);
            $table->integer('createdBy');
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
