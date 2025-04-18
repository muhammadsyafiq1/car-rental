<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // database/seeders/UserSeeder.php
    public function run()
    {
        \App\Models\User::factory()->count(500)->create();
    }
}
