<?php

use Illuminate\Database\Seeder;

class MolecularCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('Molecular_biology')->insert(['test_category_id' => 2,'name' => 'HIV VIRAL LOAD']);
      DB::table('Molecular_biology')->insert(['test_category_id' => 2,'name' => 'HIV PCR DNA']);
      DB::table('Molecular_biology')->insert(['test_category_id' => 2,'name' => 'HIV RESISTANCE']);
      DB::table('Molecular_biology')->insert(['test_category_id' => 2,'name' => 'HEP B VIRAL LOAD']);
      DB::table('Molecular_biology')->insert(['test_category_id' => 2,'name' => 'HCV VIRAL LOAD']);

      DB::table('Molecular_biology')->insert(['test_category_id' => 2,'name' => 'HCV GENOTYPE']);
      DB::table('Molecular_biology')->insert(['test_category_id' => 2,'name' => 'CMV VIRAL LOAD']);
      DB::table('Molecular_biology')->insert(['test_category_id' => 2,'name' => 'EBV VIRAL LOAD']);
      DB::table('Molecular_biology')->insert(['test_category_id' => 2,'name' => 'TB MDR']);
      DB::table('Molecular_biology')->insert(['test_category_id' => 2,'name' => 'MRSA PCR TESTING']);

      DB::table('Molecular_biology')->insert(['test_category_id' => 2,'name' => 'MRSA PCR PACKAGE']);
      DB::table('Molecular_biology')->insert(['test_category_id' => 2,'name' => 'HSV 1 AND 2 PCR']);
      DB::table('Molecular_biology')->insert(['test_category_id' => 2,'name' => 'SALMONELLA SSP PCR']);
    
      DB::table('Molecular_biology')->insert(['test_category_id' => 2,'name' => 'CANDIDA PCR']);
    }
}
