<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{
    User, 
    Product
};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        //$this->call(UsersSeeder::class);
        $this->call(CategoriesSeeder::class);
        //$this->call(ProductsSeeder::class);
    }
}
