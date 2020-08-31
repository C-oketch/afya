<?php

use Illuminate\Database\Seeder;

class EndocrinologyCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'TSH']);
      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'FREE T4']);
      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'FREE T3']);
      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'T4']);
      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'THYROID ANTIBODIES']);
      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'FSH']);
      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'LH']);
      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'E2']);
      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'PROLACTIN']);
      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'PROGESTERONE']);

      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'TESTOSTERONE']);
      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'B-HCG SERUM(QUANT)']);
      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'CORTISOL AM']);
      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'CORTISOL PM']);
      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'RANDOM CORTISOL']);
      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'PTH']);
      DB::table('Endocrinology')->insert(['test_category_id' => 1,'name' => 'AMH']);
    }
}
