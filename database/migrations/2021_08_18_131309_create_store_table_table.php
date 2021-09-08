<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_table', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id')->index();
            $table->integer('table_number');
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->integer('sequence');
            $table->integer('maximum')->nullable();
            $table->integer('min_shopp')->default(0);
            $table->integer('is_ready')->default(1);
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
        Schema::dropIfExists('store_table');
    }
}
