<?php

use Illuminate\Database\Seeder;

class ManufacturersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('manufacturers')->insert(['name' => 'REGAL PHARMACEUTICALS LTD','created_at' => new DateTime,'updated_at' => new DateTime]);
      DB::table('manufacturers')->insert(['name' => 'COSMOS LTD','created_at' => new DateTime,'updated_at' => new DateTime]);
      DB::table('manufacturers')->insert(['name' => 'GULF PHARMACEUTICALS INDUSTRIES','created_at' => new DateTime,'updated_at' => new DateTime]);
      DB::table('manufacturers')->insert(['name' => 'PANACEA BIOTEC','created_at' => new DateTime,'updated_at' => new DateTime]);
      DB::table('manufacturers')->insert(['name' => 'PT. TEMPO SCAN PACIFIC','created_at' => new DateTime,'updated_at' => new DateTime]);
    }
}
