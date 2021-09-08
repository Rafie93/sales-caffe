<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_address', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->integer('city_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->string('address')->nullable();
            $table->string('postalcode',5)->nullable();
            $table->double('latitude')->default(0.0);
            $table->double('longitude')->default(0.0);;
            $table->integer('is_main')->default(0);
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
        Schema::dropIfExists('user_address');
    }
}
