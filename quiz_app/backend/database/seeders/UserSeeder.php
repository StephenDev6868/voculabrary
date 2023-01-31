<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $checkUser = DB::table('users')->where([
            'name' => 'admin',
            'role_id' => 1
        ])->first();

        if (empty($checkUser)) {
            DB::table('users')->insert([
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'uuid' => Str::uuid(),
                'role_id' => 1,
                'password' => Hash::make('1'),
            ]);
        }

    }
}
