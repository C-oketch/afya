<?php
 //filter.php
 if(isset($_POST["from_date"], $_POST["to_date"]))
 {

      $output = '';

      $drugac = DB::table('prescriptions')
       ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
       ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
       ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
       ->Join('facilities', 'prescriptions.facility_id', '=', 'facilities.FacilityCode')
       ->Join('doctors', 'prescriptions.doc_id', '=', 'doctors.doc_id')
       ->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
       ->leftJoin('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
       ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
       'prescription_filled_status.substitute_presc_id')
     ->where([ ['druglists.Manufacturer','like', '%' . 'MERCK' . '%'],


           ])
->whereBetween('date', ['2015-08-01', '2015-08-20'])->get();
     ->get();


      $output .= '
      <table class="table table-striped table-bordered table-hover dataTables-example" >

           <tr>
            <th>No</th>
            <th>Drug Name</th>
            <th>Prescribing Doctor</th>
            <th>Facility</th>
            <th>Pharmacy  name</th>
            <th> Quantity</th>
            <th>Dosage</th>
            <th>Dosage form</th>
            <th>Unit Cost</th>
            <th>Total  </th>
                 </tr>
      ';
      if(mysqli_num_rows($result) > 0)
      {
           while($row = mysqli_fetch_array($result))
           {
                $output .= '
                @foreach($drugc as $mandrug)
                <?php $total= ($mandrug->quantity * $mandrug->price);

                   ?>
                   <tr>
                   <td>{{$i}}</td>
                   <td> <?php if($mandrug->substitute_presc_id){
                   $drugs = DB::table('substitute_presc_details')
                   ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
                   ->select('druglists.drugname as subdrugname')
                   ->where([ ['druglists.Manufacturer','like', '%' . 'MERCK' . '%'],
                           ['substitute_presc_details.id','=',$mandrug->substitute_presc_id],
                         ])
                   ->first();
                   echo $drugs->subdrugname;
                   }
                   else{ echo $mandrug->drugname;   } ?>

                   </td>
                   <td>{{$mandrug->name}}</td>
                   <td>{{$mandrug->FacilityName}}</td>
                   <td>{{$mandrug->pharmacy}}</td>
                   <td>{{$mandrug->quantity}}</td>
                   <td>{{$mandrug->dose_given}}</td>
                   <td>{{$mandrug->price}}</td>
                   <td>{{$total}}</td>
                   </tr>
                   <?php $i++;  ?>
                   @endforeach
                ';
           }
      }
      else
      {
           $output .= '
                <tr>
                     <td colspan="5">No Order Found</td>
                </tr>
           ';
      }
      $output .= '</table>';
      echo $output;
 }
 ?>
