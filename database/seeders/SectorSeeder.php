<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sector;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sector::create(
            [
                'name' => 'Marketing',
                'key' => 'marketing',
                'description' => 'Marketing sector'
            ],
        );

        Sector::create(
            [
                'name' => 'Finance',
                'key' => 'finance',
                'description' => 'Finance sector'
            ]
        );

        Sector::create(
            [
                'name' => 'Business',
                'key' => 'business',
                'description' => 'Business sector'
            ]
        );

        Sector::create(
            [
                'name' => 'Sport',
                'key' => 'sport',
                'description' => 'Finance sector'
            ]
        );

    }


}
