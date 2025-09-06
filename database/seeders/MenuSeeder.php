<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Menu::insert([
            ['name'=>'Nasi Goreng','category'=>'makanan','price'=>20000,'description'=>'Nasi goreng spesial','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Mie Ayam','category'=>'makanan','price'=>18000,'description'=>null,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Es Teh','category'=>'minuman','price'=>6000,'description'=>null,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Jus Jeruk','category'=>'minuman','price'=>12000,'description'=>null,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}

