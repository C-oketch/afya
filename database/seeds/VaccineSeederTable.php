<?php

use Illuminate\Database\Seeder;

class VaccineSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('vaccine')->insert(['disease' =>'Tuberculosis','antigen' => 'BCG','age'=>'0']);
      DB::table('vaccine')->insert(['disease' =>'Polio','antigen' => 'OPV','age'=>'0']);
      DB::table('vaccine')->insert(['disease' =>'Hepatits','antigen' => 'HEP.B','age'=>'0']);

    DB::table('vaccine')->insert(['disease' =>'Diptheria,Pertussis,Tetenus','antigen' => 'DPT','age'=>'42']);
    DB::table('vaccine')->insert(['disease' =>'Haemophilae Influenza Type B','antigen' => 'HIB','age'=>'42']);
    DB::table('vaccine')->insert(['disease' =>'Polio','antigen' => 'OPV','age'=>'42']);
    DB::table('vaccine')->insert(['disease' =>'Hepatits B','antigen' => 'HEP B','age'=>'42']);
    DB::table('vaccine')->insert(['disease' =>'Pneumonia ','antigen' => 'PNEUMOCOCCAL','age'=>'42']);
    DB::table('vaccine')->insert(['disease' =>'Rotavirus','antigen' => 'ROTA VIRUS','age'=>'42']);

     DB::table('vaccine')->insert(['disease' =>'Diptheria,Pertussis,Tetenus','antigen' => 'DPT','age'=>'70']);
      DB::table('vaccine')->insert(['disease' =>'Haemophilae Influenza Type B','antigen' => 'HIB','age'=>'70']);
      DB::table('vaccine')->insert(['disease' =>'Polio','antigen' => 'OPV','age'=>'70']);
      DB::table('vaccine')->insert(['disease' =>'Hepatits B','antigen' => 'HEP B','age'=>'70']);
      DB::table('vaccine')->insert(['disease' =>'Pneumonia','antigen' => 'PNEUMOCOCCAL','age'=>'70']);
      DB::table('vaccine')->insert(['disease' =>'Rotavirus','antigen' => 'ROTA VIRUS','age'=>'70']);

      DB::table('vaccine')->insert(['disease' =>'Diptheria,Pertussis,Tetenus','antigen' => 'DPT','age'=>'98']);
     DB::table('vaccine')->insert(['disease' =>'Haemophilae Influenza Type B','antigen' => 'HIB','age'=>'98']);
   DB::table('vaccine')->insert(['disease' =>'Polio','antigen' => 'OPV','age'=>'98']);
   DB::table('vaccine')->insert(['disease' =>'Hepatits B','antigen' => 'HEP B','age'=>'98']);
   DB::table('vaccine')->insert(['disease' =>'Pneumonia','antigen' => 'PNEUMOCOCCAL','age'=>'98']);
   DB::table('vaccine')->insert(['disease' =>'Rotavirus','antigen' => 'ROTA VIRUS','age'=>'98']);

   DB::table('vaccine')->insert(['disease' =>'Vitamin A Deficiency','antigen' => 'VIT A','age'=>'183']);

   DB::table('vaccine')->insert(['disease' =>'Measles','antigen' => 'MEASLES','age'=>'274']);
   DB::table('vaccine')->insert(['disease' =>'Yellow fever','antigen' => 'YELLOW FEVER','age'=>'274']);


   DB::table('vaccine')->insert(['disease' =>'Flu vaccine','antigen' => 'Flu vaccine','age'=>'183']);

   DB::table('vaccine')->insert(['disease' =>'Chicken Pox I','antigen' => 'Chicken Pox I','age'=>'274']);
   DB::table('vaccine')->insert(['disease' =>'Chicken Pox II','antigen' => 'Chicken Pox II','age'=>'335']);
   DB::table('vaccine')->insert(['disease' =>'Meningitis','antigen' => 'Menectra 1','age'=>'274']);

   DB::table('vaccine')->insert(['disease' =>'Mumps,Measles and Rubella','antigen' => 'MMR','age'=>'456']);
  DB::table('vaccine')->insert(['disease' =>'Typhoid','antigen' => 'Typhoid','age'=>'730']);









      
    }
}
