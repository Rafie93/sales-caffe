<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_voucher', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id')->index();
            $table->string('code');
            $table->integer('amount');
            $table->string('amount_type')->default('percentage')->comments('percentage, nominal');
            $table->integer('is_higher_amount')->default(0);
            $table->integer('higher_amount')->default(0);
            $table->integer('maximum_amount')->nullable();
            $table->integer('maximum_user')->nullable();
            $table->datetime('expired_at')->nullable();
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
        Schema::dropIfExists('store_voucher');
    }
}
