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
            [
                'username' => 'super',
                'name'     => 'Super Admin',
                'hp'       => '0895337845511',
                'password' => Hash::make(sha1(md5(123456))),
                'address'  => 'Perum Villa Permata Cikampek Blok EG 2 / 27',
                'level'    => 1,
                'status'   => 1,
            ]
        ]);
    }
}
