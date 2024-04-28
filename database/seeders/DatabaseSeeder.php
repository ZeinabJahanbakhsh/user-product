<?php

namespace Database\Seeders;

use App\Models\Product\Order;
use App\Models\Product\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        DB::table('products')->truncate();
        DB::table('orders')->truncate();

        $this->call([
           UserSeeder::class,
        ]);

        Product::factory(10)->create();
        Order::factory(10)->create();

    }
}
