<?php

namespace Database\Seeders;


use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'editorial design manager';
        $role->key =Role::ROLE_EDITORIAL_DESIGN_MANAGER;
        $role->description = 'editorial design manager';
        $role->save();




    }

}
