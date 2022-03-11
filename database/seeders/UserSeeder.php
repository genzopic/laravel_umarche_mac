<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//
use Illuminate\Support\Facades\DB;
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
        //
        DB::table('users')->insert([
            'name' => 'test_user',
            'email' => 'test@test.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => '2022/02/17 13:23',
            'created_at' => '2022/02/17 13:22',
        ]);
    }
}
