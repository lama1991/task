<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meals')->insert([
            'name' => 'Salad',
           'price'=>30.00,
           'restaurant_id'=>1
         ]);
         DB::table('meals')->insert([
          'name' => 'Spaghety',
         'price'=>50.00,
         'restaurant_id'=>1
       ]);
       DB::table('meals')->insert([
        'name' => 'Bizza',
       'price'=>150.03,
       'restaurant_id'=>1
     ]);
     DB::table('meals')->insert([
      'name' => 'Hommos',
     'price'=>75,
     'restaurant_id'=>2
   ]);
   DB::table('meals')->insert([
    'name' => 'flafel',
   'price'=>80,
   'restaurant_id'=>2
 ]);
 DB::table('meals')->insert([
  'name' => 'Fattah',
 'price'=>180,
 'restaurant_id'=>2
]);
DB::table('meals')->insert([
  'name' => 'pottatoe',
 'price'=>180,
 'restaurant_id'=>3
]);
DB::table('meals')->insert([
  'name' => 'shish',
 'price'=>180,
 'restaurant_id'=>3
]);
DB::table('meals')->insert([
  'name' => 'fish',
 'price'=>180,
 'restaurant_id'=>3
]);
DB::table('meals')->insert([
  'name' => 'pottatoe',
 'price'=>180,
 'restaurant_id'=>4
]);
DB::table('meals')->insert([
  'name' => 'yabraq',
 'price'=>200,
 'restaurant_id'=>4
]);
     
    }
}
