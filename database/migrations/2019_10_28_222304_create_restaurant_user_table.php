<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_user', function (Blueprint $table) {
            // FIXME: delete this table and model and start fresh
            // $table->increments('id');
            // FIXME: string saved not id
            $table->string('restaurant_id');
            $table->string('restaurant')->default('');
            $table->string('user_id');
            $table->string('user')->default('');
            // $table->unique(['user_id', 'restaurant_id']);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_user');
    }
}
