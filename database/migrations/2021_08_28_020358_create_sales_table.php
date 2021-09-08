<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->date('date');
            $table->integer('member_id');
            $table->integer('store_id');
            $table->integer('type_sales')->default(1)->comment('1 is product, 2 is paketan produk', '3 is event','4 is voucher reservation');
            $table->integer('sub_total')->default(0);
            $table->integer('variant_total')->defaul(0);
            $table->integer('shipping_total')->default(0);
            $table->integer('tax_total')->default(0);
            $table->integer('discount_total')->default(0);
            $table->integer('admin_total')->default(0);
            $table->integer('point_total')->default(0);
            $table->integer('grand_total')->default(0);
            $table->integer('modal_total')->default(0);
            $table->string('payment_method')->nullable();
            $table->string('payment_channel')->nullable();
            $table->string('service',50)->comment('delivery|take_away|dine_in|reservation')->default('delivery');
            $table->string('service_type',50)->nullable();
            $table->string('shipping_method',50)->nullable();
            $table->string('delivery_to')->nullable();
            $table->date('pickup_date')->nullable();
            $table->time('pickup_time')->nullable();
            $table->date('seat_reservation_date')->nullable();
            $table->time('seat_reservation_start')->nullable();
            $table->time('seat_reservation_end')->nullable();
            $table->string('seat',50)->nullable();
            $table->string('voucher_code')->nullable();
            $table->integer('status')->comment('0 : draft, 1 : waiting payment, 2 : prepare order, 3 : delivery|product ready to pick, 4 : order accepted', 'completed');
            $table->string('notes')->nullable();
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
