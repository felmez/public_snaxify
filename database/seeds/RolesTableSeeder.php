<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
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
        // Role::truncate();
        // FIXME: can NOT truncate with foreign key in table

        Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => json_encode([
                'create-res' => true,
            ]),
        ]);
        Role::create([
            'name' => 'Owner',
            'slug' => 'owner',
            'permissions' => json_encode([
                'view-res' => true,
                'update-res' => true,
            ]),
        ]);


        // Role::create(['name' => 'owner']);
        // Role::create(['name' => 'customer']);
    }
}
