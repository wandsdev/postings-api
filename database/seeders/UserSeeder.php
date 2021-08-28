<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        DB::table('users')->insert([
            'name' => 'João Da Silva',
            'email' => 'joao@oi.com',
            'password' => Hash::make('joao1000'),
            'email_verified' => true,
        ]);

        DB::table('users')->insert([
            'name' => 'Maria',
            'email' => 'maria@oi.com',
            'password' => Hash::make('maria1000'),
            'email_verified' => 1,
        ]);
    }
}
