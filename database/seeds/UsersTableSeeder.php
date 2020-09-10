<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
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
        // User::truncate(); not working maybe conflicting with api token since this is user and there is admin
        // $adminRole = Role::where('name', 'admin')->first();
        // $ownerRole = Role::where('name', 'owner')->first();
        // $customerRole = Role::where('name', 'customer')->first();
        // User::truncate();
        // User::create([
        //     'name' => 'Admin',
        //     'username' => 'admin',
        //     'email' => 'admin@admin.com',
        //     'password' => bcrypt('newnew'),
        //     'role_id' => 'Admin',
        //     'role' => 'Admin',
        //     'restaurant' => '',
        //     'restaurant_id' => ''
        // ]);
        // User::create([
        //     'name' => 'Fatih',
        //     'username' => 'fatih',
        //     'email' => 'fatih@fatih.com',
        //     'password' => bcrypt('newnew'),
        //     'role_id' => 'Owner',
        //     'role' => 'Owner',
        //     'restaurant' => '1',
        //     'restaurant_id' => '1'
        // ]);
        // User::create([
        //     'name' => 'Esenyurt',
        //     'username' => 'esenyurt',
        //     'email' => 'esenyurt@esenyurt.com',
        //     'password' => bcrypt('newnew'),
        //     'role_id' => 'Owner',
        //     'role' => 'Owner',
        //     'restaurant' => '2',
        //     'restaurant_id' => '2',
        // ]);
        // $owner = User::create([
        //     'name' => 'Owner',
        //     'email' => 'owner@owner.com',
        //     'password' => bcrypt('owner'),
        //     'role' => 'owner',
        // ]);
        // $customer = User::create([
        //     'name' => 'Customer',
        //     'email' => 'customer@customer.com',
        //     'password' => bcrypt('customer'),
        //     'role' => 'customer',
        // ]);

        // $admin->roles()->attach($adminRole);
        // $owner->roles()->attach($ownerRole);
        // $customer->roles()->attach($customerRole);

    }
}
