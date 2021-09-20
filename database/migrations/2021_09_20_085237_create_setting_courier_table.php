<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingCourierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_courier', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('distance');
            $table->integer('rate');
            $table->char('state_id', 2)->index()->nullable();
            $table->char('city_id', 4)->index()->nullable();
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
        Schema::dropIfExists('setting_courier');
    }
}
