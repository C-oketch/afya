<?php

use Illuminate\Database\Seeder;

class TumourCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('tumour_markers')->insert(['test_category_id' => 1,'name' => 'PSA']);
      DB::table('tumour_markers')->insert(['test_category_id' => 1,'name' => 'CEA']);
      DB::table('tumour_markers')->insert(['test_category_id' => 1,'name' => 'CA 19-9']);
      DB::table('tumour_markers')->insert(['test_category_id' => 1,'name' => 'CA 125']);
      DB::table('tumour_markers')->insert(['test_category_id' => 1,'name' => 'HE 4']);
      DB::table('tumour_markers')->insert(['test_category_id' => 1,'name' => 'AFP']);
      DB::table('tumour_markers')->insert(['test_category_id' => 1,'name' => 'CA 15-3']);
      DB::table('tumour_markers')->insert(['test_category_id' => 1,'name' => '5 HIAA']);
      DB::table('tumour_markers')->insert(['test_category_id' => 1,'name' => 'OCCULT BLOOD']);

    }
}
