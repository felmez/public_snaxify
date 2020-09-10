<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // tole will attached automatically
            // FIXME: nullability on ids
            $table->string('restaurant_id')->nullable();
            $table->string('restaurant')->nullable();
            $table->string('role_id')->nullable();
            $table->string('role');
            $table->increments('id');
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('access_order_statuses')->default(true);
            $table->boolean('access_delivery_boys')->default(true);
            $table->boolean('access_full')->default(true);
            $table->boolean('access_news')->default(true);
            $table->boolean('access_categories')->default(true);
            $table->boolean('access_products')->default(true);
            $table->boolean('access_orders')->default(true);
            $table->boolean('access_customers')->default(true);
            $table->boolean('access_pushes')->default(true);
            $table->boolean('access_delivery_areas')->default(true);
            $table->boolean('access_promo_codes')->default(true);
            $table->boolean('access_tax_groups')->default(true);
            $table->boolean('access_cities')->default(true);
            $table->boolean('access_restaurants')->default(true);
            $table->boolean('access_settings')->default(true);
            $table->boolean('access_users')->default(true);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
