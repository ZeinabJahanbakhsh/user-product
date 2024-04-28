<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       /* User::create([
            'name'     => 'Admin',
            'email'    => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);*/

        DB::table('users')->insert([
            'name'     => 'Admin',
            'email'    => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);

    }

}
