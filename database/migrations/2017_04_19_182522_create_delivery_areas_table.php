<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_areas', function (Blueprint $table) {
            $table->string('owner_username');
            // $table->string('restaurant');
            $table->integer('restaurant_id')->unsigned()->nullable(true)->default(null);
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('set null');
            $table->increments('id');
            $table->string('name');
            $table->text('coords');
            $table->float('price')->nullable(true);
            $table->integer('city_id')->unsigned()->nullable(true)->default(null);
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
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
        Schema::dropIfExists('delivery_areas');
    }
}
