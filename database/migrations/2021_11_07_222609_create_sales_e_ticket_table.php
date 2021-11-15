<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesETicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('sales_event_id');
            $table->integer('event_id');
            $table->string('participant_name')->nullable();
            $table->string('phone',16);
            $table->integer('status')->default(1)->comment('1:eticket,2:digunakan,3:expired');
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
        Schema::dropIfExists('sales_e_ticket');
    }
}
