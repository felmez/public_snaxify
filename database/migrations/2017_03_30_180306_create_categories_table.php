<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            // FIXME: no default value on creating
            // $table->string('restaurant');
            $table->integer('restaurant_id')->unsigned()->nullable(true)->default(null);
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('set null');
            $table->integer('city_id')->unsigned()->nullable(true)->default(null);
            $table->string('name');
            $table->string('owner_username');
            $table->string('image')->nullable(true)->default(null);
            NestedSet::columns($table);
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
        Schema::table('categories', function (Blueprint $table) {
            NestedSet::dropColumns($table);
        });
        Schema::dropIfExists('categories');
    }
}
