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

        $role = new Role();
        $role->name = 'ceo';
        $role->key =Role::ROLE_CEO;
        $role->description = 'ceo';
        $role->save();

        $role = new Role();
        $role->name = 'editorial director';
        $role->key =Role::ROLE_EDITORIAL_DIRECTOR;
        $role->description = 'editorial director';
        $role->save();

        $role = new Role();
        $role->name = 'editorial responsible';
        $role->key =Role::ROLE_EDITORIAL_RESPONSIBLE;
        $role->description = 'editorial responsible';
        $role->save();

        $role = new Role();
        $role->name = 'sales director';
        $role->key =Role::ROLE_SALES_DIRECTOR;
        $role->description = 'sales director';
        $role->save();

        $role = new Role();
        $role->name = 'admin';
        $role->key =Role::ROLE_ADMIN;
        $role->description = 'admin';
        $role->save();




    }

}
