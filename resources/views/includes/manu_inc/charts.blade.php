<?php  
           use Carbon\Carbon;
           $today= Carbon::now();
           $monday = Carbon::now()->startOfWeek();
           $tuesday=  $monday->addDays(1);
           $wednesday= $tuesday->addDays(1);
           $thursday=$wednesday->addDays(1);
           $friday=$thursday->addDays(1);
           $saturday=$friday->addDays(1);
           $sunday=$saturday->addDays(1);
          
$id=Auth::id();
$manufacturer=DB::table('manufacturers')->where('user_id', Auth::id())->first(); 
            if($manufacturer==''){
                $name = 'name';
            }
            else{
                $name=$manufacturer->name;
            }

            $from = date('Y-m-d' ." ". '08:00:00', time()); $to = date('Y-m-d' ." ". '09:59:59', time());
            $from1 = date('Y-m-d' ." ". '10:00:00', time()); $to1 = date('Y-m-d' ." ". '12:59:59', time());
            $from2 = date('Y-m-d' ." ". '13:00:00', time()); $to2 = date('Y-m-d' ." ". '15:59:59', time());
            $from3 = date('Y-m-d' ." ". '16:00:00', time()); $to3 = date('Y-m-d' ." ". '18:59:59', time());
            $from4 = date('Y-m-d' ." ". '19:00:00', time()); $to4 = date('Y-m-d' ." ". '21:59:59', time());
            $from5 = date('Y-m-d' ." ". '22:00:00', time()); $to5 = date('Y-m-d' ." ". '00:59:59', time());
            $from6 = date('Y-m-d' ." ". '01:00:00', time()); $to6 = date('Y-m-d' ." ". '03:59:59', time());
            $from7 = date('Y-m-d' ." ". '05:00:00', time()); $to7 = date('Y-m-d' ." ". '07:59:59', time());
           
//Today

$d1=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from, $to))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
        $d2=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from1, $to1))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
        $d3=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from2, $to2))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
         $d4=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from3, $to3))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
          $d5=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from4, $to4))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
           $d6=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from5, $to5))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
            $d7=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from6, $to6))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
             $d8=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from7, $to7))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
    //This week

 $mon=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->where('prescription_filled_status.created_at','>=',$monday)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
 $tue=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->where('prescription_filled_status.created_at','>=',$tuesday)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
 $wed=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('prescription_filled_status.created_at','>=',$wednesday)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
 $thur=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('prescription_filled_status.created_at','>=','2017-05-18')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
 $fri=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->where('prescription_filled_status.created_at','>=',$friday)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
 $sat=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->where('prescription_filled_status.created_at','>=',$saturday)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
 $sun=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->where('prescription_filled_status.created_at','>=',$sunday)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();


//This Month
          $monthstart = $today->startOfMonth();
           $first= $monthstart->addDays(7);
           $second=$first->addDays(7);
           $third=$second->addDays(7);
          $monthend = $today->endOfMonth();

$week1=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->where('prescription_filled_status.created_at','>=',$monthstart)->where('prescription_filled_status.created_at','<=',$first)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
$week2=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('prescription_filled_status.created_at','<=',$first)->where('prescription_filled_status.created_at','>=',$second)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
$week3=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->where('prescription_filled_status.created_at','>=',$second)->where('prescription_filled_status.created_at','>=',$third)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
$week4=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->where('prescription_filled_status.created_at','>=',$third)->where('prescription_filled_status.created_at','<=',$monthend)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();


               ?>
