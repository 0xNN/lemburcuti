<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([[
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'is_admin' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'name' => 'Kepala Cabang',
            'username' => 'kepala_cabang',
            'email' => 'kepala_cabang@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'is_admin' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]]);
    }
}
