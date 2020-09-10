<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            // FIXME: not working since no default value
            // $table->integer = auth()->id();
            // $table->integer('owner_id')->unsigned();
            // $table->string('title');
            // $table->string('slug')->unique();
            $table->integer('owner_id');
            $table->string('owner_name');
            $table->string('owner_username');
            $table->increments('id');
            $table->string('name')->default('');
            $table->string('username');
            $table->string('image')->default('');
            $table->integer('sort')->default(500);
            $table->timestamps();
            // $table->foreign('owner_id')->references('id')->on('users');
            
            

            // not needed yet 
            $table->integer('city_id')->unsigned()->nullable(true)->default(null);
            // $table->user_id = Auth::user()->id;
            // $table->save();
            // $restaurant->user_id =  auth()->user()->id;
            // $article->user_id =  auth()->user()->id;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
