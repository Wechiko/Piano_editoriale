<?php

namespace Database\Seeders;

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
        $user->surname = 'Admin';
        $user->email = 'admin@test.it';
        $user->password = Hash::make('password');
        $user->save();

        User::factory()->count(50)->create();
    }
}
