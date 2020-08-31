@extends('layouts.pharmacy')
@section('content')


<div class="wrapper wrapper-content animated fadeInRight">

<div class="row">
<div class="col-lg-12">
 <div class="ibox float-e-margins">
 <div class="ibox-title">
     <h5>Prescription Details</h5>

 </div>

 <div class="ibox-content">

 <div class="table-responsive">
   <table class="table table-striped table-bordered table-hover dataTables-example" >
   <thead>


     <tr>
         <th>No</th>
         <th>Name</th>
         <th>Drug</th>
         <th>Strength</th>
         <!-- <th>Strength Unit</th>
         <th>Route</th>
         <th>Frequency</th> -->
         <th></th>
     </tr>
     </thead>
     <tbody>

       <?php

       if(isset($patients) && !empty($patients))
       {

       $i =1;
       foreach ($patients as $patient)
       {

         $af_id = $patient->af_id;
         /* Get total amount of that specific drug that has been given  */
         $id = $patient->presc_id;
         $query1 = DB::table('prescription_filled_status')
                 ->select(DB::raw('SUM(dose_given) AS total_given'))
                 ->where('presc_details_id','=',$id)
                 ->first();
         $count1 = $query1->total_given;

         /* Get the prescribed strength of the drug($id) */
         $query2 = DB::table('prescription_details')
                 ->where('id', '=', $id)
                 ->first();
         $count2 = $query2->strength;

         $new_strength = $count2 - $count1; //the remaining dosage

         $person_treated = $patient->persontreated;

         /**
         *Check if drug is in stock ,if not disable "fill prescription button/hyperlink"
         */
         $drug_id = $patient->drug_id;
         $amount_needed = $new_strength; //prescription strength

         /*Get amount inserted in inventory*/
         $stocks = DB::table('inventory')
                  ->select(DB::raw('SUM(strength * quantity) AS stock'))
                  ->where('drug_id', '=', $drug_id)
                  ->first();

          $level = $stocks->stock;

         /*Get amount sold as prescribed by doctor*/
         $counter1 = DB::table('prescription_filled_status')
                ->join('prescription_details', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
                ->select(DB::raw('SUM(prescription_filled_status.dose_given * prescription_filled_status.quantity) AS count1'))
                ->where('prescription_details.drug_id', '=', $drug_id)
                ->first();

          /*Get amount sold by susbtitution*/
          $counter2 = DB::table('prescription_filled_status')
                 ->join('prescription_details', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
                 ->join('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
                 ->select(DB::raw('SUM(substitute_presc_details.strength * prescription_filled_status.quantity) AS count2'))
                 ->where('substitute_presc_details.drug_id', '=', $drug_id)
                 ->first();

         $amount_sold = $counter1->count1 + $counter2->count2;
         $stock_level = $level - $amount_sold;
         

         ?>
     <tr class="gradeX">

     <td>{{$i}}</td>
     <?php
     if($person_treated == 'Self')
     {
      ?>
     <td>{{$patient->firstname.' '.$patient->secondName}}</td>
     <?php
     }
     else
     {
       $depends = DB::table('dependant')
                 ->select('dependant.firstName AS fname', 'dependant.secondName AS sname')
                 ->where('afya_user_id', '=', $af_id)
                 ->first();
       $fname = $depends->fname;
       $sname = $depends->sname;
       ?>
       <td>{{$fname.' '.$sname}}</td>
     <?php }
      ?>
     <td>{{$patient->drugname}}</td>
     <td>{{$new_strength}}</td>
     <!-- <td>{{-- $patient->strength_unit --}}</td>
     <td>{{-- $patient->name --}}</td>
     <td>{{-- $patient->freq_name --}} </td> -->
     <td>
    <div class="text-center">
      <?php
      if($stock_level >= $amount_needed)
      {
       ?>
    <a class="btn btn-primary btn-rounded" href="{{ route('fillpresc',$patient->presc_id) }}" >Fill Prescription</a>
    <?php
  }
  else
  {
     ?>
     <a class="btn btn-primary btn-rounded"  href="{{ route('substitution',$patient->presc_id) }}" >Out of Stock</a>
     <?php
   }
      ?>
    </div>
    </td>



     </tr>
     <?php
     $i++;
   }

 } //end isset patients

 if(isset($alt_patients))
 {

 $i =1;
 foreach ($alt_patients as $alt_patient)
 {

   $af_id = $alt_patient->af_id;
   /* Get total amount of that specific drug that has been given  */
   $id = $alt_patient->presc_id;
   $query1 = DB::table('prescription_filled_status')
           ->select(DB::raw('SUM(dose_given) AS total_given'))
           ->where('presc_details_id','=',$id)
           ->first();
   $count1 = $query1->total_given;

   /* Get the prescribed strength of the drug($id) */
   $query2 = DB::table('prescription_details')
           ->where('id', '=', $id)
           ->first();
   $count2 = $query2->strength;

   $new_strength = $count2 - $count1; //the remaining dosage


   /**
   *Check if drug is in stock ,if not disable "fill prescription button/hyperlink"
   */
   $drug_id = $alt_patient->drug_id;
   $amount_needed = $new_strength; //prescription strength

   /*Get amount inserted in inventory*/
   $stocks = DB::table('inventory')
            ->select(DB::raw('SUM(strength * quantity) AS stock'))
            ->where('drug_id', '=', $drug_id)
            ->first();

    $level = $stocks->stock;

   /*Get amount sold as prescribed by doctor*/
   $counter1 = DB::table('prescription_filled_status')
          ->join('prescription_details', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
          ->select(DB::raw('SUM(prescription_filled_status.dose_given * prescription_filled_status.quantity) AS count1'))
          ->where('prescription_details.drug_id', '=', $drug_id)
          ->first();

    /*Get amount sold by susbtitution*/
    $counter2 = DB::table('prescription_filled_status')
           ->join('prescription_details', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
           ->join('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
           ->select(DB::raw('SUM(substitute_presc_details.strength * prescription_filled_status.quantity) AS count2'))
           ->where('substitute_presc_details.drug_id', '=', $drug_id)
           ->first();

   $amount_sold = $counter1->count1 + $counter2->count2;
   $stock_level = $level - $amount_sold;

   ?>
<tr class="gradeX">

<td>{{$i}}</td>
<?php

$dep = DB::table('prescriptions')
      ->leftJoin('dependant', 'dependant.id', '=', 'prescriptions.dependant_id')
      ->where([
        ['prescriptions.afya_user_id', '=', $af_id],
        ['prescriptions.id', '=', $alt_patient->the_id]
      ])
      ->first();

if(! isset($dep->dependant_id)) //persontreated is afya user
{

?>
<td>{{$alt_patient->firstname.' '.$alt_patient->secondName}}</td>
<?php
}
else //persontreated is dependant
{
  $depends = DB::table('prescriptions')
          ->leftJoin('dependant', 'dependant.id', '=', 'prescriptions.dependant_id')
          ->select('dependant.firstName AS fname', 'dependant.secondName AS sname')
          ->where([
            ['prescriptions.afya_user_id', '=', $af_id],
            ['prescriptions.id', '=', $alt_patient->the_id]
          ])
          ->first();

 $fname = $depends->fname;
 $sname = $depends->sname;

 ?>
 <td>{{$fname.' '.$sname}}</td>
<?php }
?>
<td>{{$alt_patient->drugname}}</td>
<td>{{$new_strength}}</td>
<td>{{$alt_patient->strength_unit}}</td>
<td>{{$alt_patient->name}}</td>
<td>{{$alt_patient->freq_name}} </td>
<td>
<div class="text-center">
<?php
if($stock_level >= $amount_needed)
{
 ?>
<a class="btn btn-primary btn-rounded" href="{{ route('alt_fillpresc',$alt_patient->presc_id) }}" >Fill Prescription</a>
<?php
}
else
{
?>
<a class="btn btn-primary btn-rounded"  href="{{ route('alt_substitution',$alt_patient->presc_id) }}" >Out of Stock</a>
<?php
}
?>
</div>
</td>



</tr>
<?php
$i++;
}

} //end isset alternative patients
    ?>
   </tbody>
  <tfoot>
    <tr>
      <th>No</th>
      <th>Name</th>
      <th>Drug</th>
      <th>Strength</th>
      <!-- <th>Strength Unit</th>
      <th>Route</th>
      <th>Frequency</th> -->
      <th></th>
    </tr>
    </tfoot>
    </table>
     <a href="{{route('home')}}"><button type="button" class="btn btn-w-m btn-primary">Back</button></a>
        </div>

    </div>


   </div>
   </div>

    </div><!--content-->
</div><!--content page-->


@endsection
