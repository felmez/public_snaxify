<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->float('discount');
            $table->boolean('discount_in_percent');
            $table->float('min_price')->default(0)->nullable(false);
            $table->integer('limit_use_count');
            $table->integer('times_used')->default(0)->nullable(false);
            $table->datetime('active_from');
            $table->datetime('active_to');

            $table->integer('restaurant_id')->unsigned()->nullable(true)->default(null);
            $table->integer('city_id')->unsigned()->nullable(true)->default(null);
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('set null');
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
        Schema::dropIfExists('promo_codes');
    }
}
