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
        DB::table('roles')->insert([
            'name' => 'admin'
        ]);

        DB::table('roles')->insert([
            'name' => 'alumni'
        ]);

        DB::table('users')->insert([
            'username' => 'admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('12345678'),
            'role_id' => '1'
        ]);

        DB::table('user_detail')->insert([
            'user_id' => 1,
            'nama_lengkap' => 'Yohanes Dwiki Septian',
            'nim' => 1813006
        ]);
    }
}
