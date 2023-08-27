<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('restaurants')->insert([
            'name' => 'Ashy',
            'city_id'=>1,
      
            'contact'=>'contact us on wisam@hotmail.com',
            'address'=>'Zeraah',
            'cuisine_type'=>'westrian'
         ]);

         DB::table('restaurants')->insert([
            'name' => 'Sabah',
            'city_id'=>1,
            'contact'=>'contact',
            'address'=>'address',
            'cuisine_type'=>'easterian'
         ]);
         DB::table('restaurants')->insert([
            'name' => 'We',
            'city_id'=>3,
            'contact'=>'contact',
            'address'=>'address',
            'cuisine_type'=>'westrian'
         ]);
      
    }
}
