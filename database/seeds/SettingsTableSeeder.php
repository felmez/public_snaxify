<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // call this function in database seeder db:seed
    public function run()
    {
        // to clear db before seed again means OVERWRITE be careful
        \App\Settings::truncate();

        \App\Settings::create([
            'delivery_price' => 0,
            'currency_format' => 'TL:value',
            'pushwoosh_id' => '',
            'pushwoosh_token' => '',
            'gcm_project_id' => '',
            'date_format' => 'd/m/Y H:i',
            'multiple_restaurants' => 1,
        ]);
    }
}
