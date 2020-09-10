<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->nullable(true)->default(null);
            // FIXME: general error on order last step after selecting address on mobile
            $table->string('restaurant')->default('');
            $table->integer('restaurant_id')->unsigned()->nullable(true)->default(null);
            $table->integer('city_id')->unsigned()->nullable(true)->default(null);
            $table->integer('delivery_boy_id')->unsigned()->nullable(true)->default(null);
            $table->integer('delivery_area_id')->unsigned()->default(null)->nullable(true);
            $table->integer('order_status_id')->unsigned()->nullable(true)->default(null);
            
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->float('lat')->nullable(true);
            $table->float('lng')->nullable(true);
            $table->float('total')->nullable(true);

            $table->string('promo_code')->nullable(true)->default(null);
            $table->string('promo_discount')->nullable(false)->default('');
            $table->integer('promo_code_id')->nullable(true)->default(null);

            $table->float('delivery_price')->default(0);

            $table->float('tax')->default(0);
            $table->float('total_with_tax')->default(0);

            $table->string('payment_method')->default('cash')->nullable(true);
            $table->string('paypal_id')->default('')->nullable(false);
            $table->string('stripe_token')->default('')->nullable(true);
            $table->boolean('is_paid')->default(false);

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('set null');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
            $table->foreign('delivery_boy_id')->references('id')->on('delivery_boys')->onDelete('set null');
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('set null');
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
