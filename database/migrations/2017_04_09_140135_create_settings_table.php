<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pushwoosh_id')->default('')->nullable(true);
            $table->string('pushwoosh_token')->default('')->nullable(true);
            $table->string('date_format')->default('d/m/Y H:i')->nullable(true);
            $table->string('time_format_backend')->default('d/M/Y H:i');
            $table->string('time_format_app')->default('dd/MM/yyyy HH:mm');
            $table->string('date_format_app')->default('dd/MM/yyyy');

            $table->string('currency_format')->default('')->nullable(true);
            $table->string('delivery_price')->default('')->nullable(true);
            $table->boolean('tax_included')->default(false);

            $table->boolean('signup_required')->default(false);
            $table->boolean('multiple_restaurants')->default(false);
            $table->boolean('multiple_cities')->default(false);
            $table->string('gcm_project_id')->default('')->nullable(true);
            $table->string('stripe_publishable')->default('')->nullable(true);
            $table->string('stripe_private')->default('')->nullable(true);
            $table->string('notification_email')->default('sofelmez@gmail.com');
            $table->string('notification_phone')->default('sofelmez@gmail.com');
            $table->string('mail_from_mail')->default('sofelmez@gmail.com');
            $table->string('mail_from_name')->default('sofelmez@gmail.com');
            $table->string('mail_from_new_order_subject')->default('sofelmez@gmail.com');

            $table->boolean('paypal_production')->default(false);
            $table->string('paypal_client_id')->default('')->nullable(true);
            $table->string('paypal_client_secret')->default('')->nullable(true);
            $table->string('paypal_currency')->default('')->nullable(true);

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
        Schema::dropIfExists('settings');
    }
}
