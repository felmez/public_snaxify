<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            // $table->integer('restaurants_id')->unsigned();
            $table->integer('tax_group_id')->unsigned()->default(null)->nullable(true);
            $table->string('name');
            $table->string('owner_username');
            $table->longText('description')->nullable(true);
            $table->float('price');
            $table->float('price_old')->nullable(true);
            $table->foreign('tax_group_id')->references('id')->on('tax_groups')->onDelete('set null');
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
        Schema::dropIfExists('products');
    }
}
