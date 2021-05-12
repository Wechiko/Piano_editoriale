<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Super';
        $user->email = 'admin@test.it';
        $user->password = Hash::make('password');
        $user->save();

        $role = Role::where('key',Role::ROLE_EDITORIAL_DESIGN_MANAGER)->first();
        $user->roles()->attach($role);



        User::factory()->count(50)->create();
    }
}
