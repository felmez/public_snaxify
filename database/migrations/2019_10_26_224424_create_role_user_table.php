<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            // FIXME: empty name
            // $table->string('role_name')->default('');
            // TODO: removed unsigned and converted to string not integer
            // FIXME: string stored not id
            $table->string('user_id'); 
            $table->string('user')->default(''); 
            $table->string('role_id');
            $table->string('role')->default('');
            // $table->timestamps();
            // FIXME: as blade fetching id and its string not integer got error on registration 
            // this is attaching role to user on delete and connecting
            // $table->unique(['user_id', 'role_id']);
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
    }
}
