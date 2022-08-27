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
            'nama_lengkap' => 'admin',
            'username' => 'admin',
            'nim' => 1813006,
            'email' => 'admin@mail.com',
            'password' => Hash::make('12345678'),
            'status' => 'ADMIN',
        ]);
    }
}
