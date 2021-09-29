<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {

        DB::table('user_roles')->insert([
            ['role_id' => '1', 'user_role' => 'SUPER ADMIN', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        DB::table('users')->insert([
            ['u_id' => '1', 'name' => 'Ashen Udithamal', 'role_id' => config('rcc.admin_type',1), 'username' => 'ashen',  'password' => Hash::make(123), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

    }
}
