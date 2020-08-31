@extends('layouts.doctor_layout')
@section('title', 'Prescriptions')

@section('content')



<?php
$doc = (new \App\Http\Controllers\DoctorController);
$Docdatas = $doc->DocDetails();
foreach($Docdatas as $Docdata){


$Did = $Docdata->id;
$Name = $Docdata->name;
$Address = $Docdata->address;
$RegNo = $Docdata->regno;
$RegDate = $Docdata->regdate;
$Speciality = $Docdata->speciality;
$Sub_Speciality = $Docdata->subspeciality;


}


      foreach ($patientD as $pdetails) {
        // $patientid = $pdetails->pat_id;
        //  $facilty = $pdetails->FacilityName;
         $stat= $pdetails->status;
         $afyauserId= $pdetails->afya_user_id;
          $dependantId= $pdetails->persontreated;
          $app_id= $pdetails->id;
          $doc_id= $pdetails->doc_id;
          $fac_id= $pdetails->facility_id;
          $fac_setup= $pdetails->set_up;
          $dependantAge = $pdetails->depdob;
          $AfyaUserAge = $pdetails->dob;
          $condition = $pdetails->condition;

 $now = time(); // or your date as well
 $your_date = strtotime($dependantAge);
 $datediff = $now - $your_date;
 $dependantdays= floor($datediff / (60 * 60 * 24));


 if ($dependantId =='Self') {
            $dob=$AfyaUserAge;
            $gender=$pdetails->gender;
          $firstName = $pdetails->firstname;
          $secondName = $pdetails->secondName;
          $name =$firstName." ".$secondName;
   }

 else {    $dob=$dependantAge;
           $gender=$pdetails->depgender;
           $firstName = $pdetails->dep1name;
           $secondName = $pdetails->dep2name;
           $name =$firstName." ".$secondName;
      }


  $interval = date_diff(date_create(), date_create($dob));
  $age= $interval->format(" %Y Year, %M Months, %d Days Old");


 $appStatue=$stat;
if ($appStatue == 2) {
  $appStatue ='ACTIVE';
} elseif ($stat == 3) {
  $appStatue='Discharged Outpatient';
} elseif ($stat == 4) {
  $appStatue='Admitted';
} elseif ($stat == 5) {
  $appStatue='Refered';
}
elseif ($stat == 6) {
  $appStatue='Discharged Intpatient';
}

}
?>

          <?php  $routem= (new \App\Http\Controllers\TestController);
                $routems = $routem->RouteM();
            ?>
          <?php $Strength= (new \App\Http\Controllers\TestController);
                $Strengths = $Strength->Strength();
            ?>
          <?php $frequency= (new \App\Http\Controllers\TestController);
                $frequent = $frequency->Frequency();
            ?>

          <?php
          use App\Http\Controllers\Controller;

          ?>

          @include('includes.doc_inc.topnavbar_v2')



          <!--tabs Menus-->
            @include('includes.doc_inc.headmenu')
  <!--tabs Menus-->
<div class="row wrapper border-bottom">
              <div class="ibox float-e-margins">


                   <div class="row">
                     <!--..........Patient allergy and chronic icd10_option....................-->
                     @include('doctor.allergy')
                     <!--...........Patient allergy and chronic icd10_option ........................-->
         <div class="col-lg-12">
              <div class="tabs-container">
                  <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1">PRESCRIPTIONS</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-2">PRESCRIPTIONS HISTORY</a></li>
                  </ul>

<div class="tab-content">
<div id="tab-1" class="tab-pane active">
<div class="panel-body">

  <div class="col-lg-12">
      <div class="panel panel-info">
          <div class="panel-heading">
              Diagnosis Details
          </div>
          <div class="panel-body">
            <div class="table-responsive ibox-content">
             <table class="table table-striped table-bordered table-hover " >
              <thead>
                <tr>
                  <th>Diagnosis</th>
                  <th>Severity</th>
                  <th>Chronic</th>
                  <th>Reccomendation</th>
              </tr>
                </thead>
                <tbody>
            @foreach($Pdiagnosis as $tstdn)
                  <tr>
                  <td>@if($tstdn->name){{$tstdn->name}} @else{{$tstdn->radiology}}@endif</td>
                  <td>@if($tstdn->name){{$tstdn->severity}} @else{{$tstdn->notes}}@endif</td>
                  <td>@if($tstdn->name){{$tstdn->chronic}}@endif</td>

                  <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                     data-target="#myModal5">Drugs</button></td>
                 </tr>

            @endforeach
            </tbody>
            </table>
              </div>
          </div>
      </div>
  </div>


 <div class="row col-lg-12">
    <div class="table-responsive panel panel-primary">
          <div class="panel-heading">
              Write Prescription
          </div>

             <div class="panel-body">
               <table class="table table-striped table-bordered table-hover drugs">
                    <thead>
                           <th>Prescription for</th>
                           <th>Drug Name</th>
                           <th>Ingridients</th>
                           <th>Strength</th>
                           <th>Manufacturer</th>
                           <th>Route</th>
                           <th>Frequency</th>
                          <th>Options</th>
                    </thead>
                    <tbody>

                      @foreach($drugs as $drug)
                          <tr>

                             <td>
                                <select class="form-control" name="disease_id" id="disease_id{{$drug->id}}" style="width:100px;">
                                    @foreach($Pdiagnosis as $tstdn)
                                           <option value='{{$tstdn->id}}'>@if($tstdn->name){{$tstdn->name}} @else{{$tstdn->radiology}}@endif</option>
                                    @endforeach
                                </select>
                             </td>
                             <td>
                              {{$drug->drugname}}

                             </td>
                             <td>{{$drug->Ingridients}}</td>
                             <td>
                              {{$drug->strength_perdose}}
                              </td>
                             <td>{{$drug->Manufacturer}}</td>

                             <td>

                               <select class="form-control" name="routes" id="routes{{$drug->id}}" style="width:100px;">
                                     @foreach($routems as $routemz)
                                       <option value="{{$routemz->id }}">{{ $routemz->abbreviation }}----{{ $routemz->name  }} </option>
                                    @endforeach
                                 </select>
                             </td>
                             <td>

                               <select class="form-control"  name="frequency"  id="frequency{{$drug->id}}" style="width:100px;">
                                     @foreach($frequent as $freq)
                                       <option value="{{$freq->id }}">{{ $freq->abbreviation }}----{{ $freq->name  }} </option>
                                    @endforeach
                                 </select>
                             </td>

                             <td>
                        <?php $detail_id=Controller::detail_id($app_id,$drug->id); ?>

                          @if(Controller::is_prescribed($app_id,$drug->id))
                        <div class="p{{$drug->id}}">
                          <button class="btn btn-danger" type="button" onClick="delete_presc_detail('{{$detail_id}}','{{$drug->id}}')"><span class="glyphicon glyphicon-minus"></span>REMOVE</button>
                        </div>
                          @else
                        <div class="p{{$drug->id}}">
                         <button class="btn btn-primary" type="button" onClick="insert_presc_detail('{{$detail_id}}','{{$drug->id}}','{{$drug->strength_perdose}}')"><span class="glyphicon glyphicon-plus"></span>ADD</button>
                       </div>
                         @endif



                             </td>
                            </tr>
                      @endforeach

                    </tbody>
               </table>
             </div>
        </div>
</div>







</div>
  </div>

<div id="tab-2" class="tab-pane">
<div class="panel-body">
<?php $i =1;
if ($dependantId =='Self') {

$tstdone = DB::table('appointments')
->Join('prescriptions', 'appointments.id', '=', 'prescriptions.appointment_id')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('patient_diagnosis', 'prescription_details.diagnosis', '=', 'patient_diagnosis.id')
->leftJoin('icd10_option', 'patient_diagnosis.disease_id', '=', 'icd10_option.id')
->leftJoin('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->leftJoin('frequency', 'prescription_details.frequency', '=', 'frequency.id')
->leftJoin('route', 'prescription_details.routes', '=', 'route.id')
->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->select('icd10_option.name','druglists.drugname','frequency.name as frequency','prescription_details.created_at',
'prescription_details.id as prescdid',
'route.name as route','prescription_filled_status.start_date','prescription_filled_status.end_date'
,'prescriptions.filled_status as pstatus','patient_diagnosis.disease_id as diagdisease','patient_diagnosis.radiology')
->where('appointments.afya_user_id', '=',$afyauserId)
->where('prescription_details.deleted', '=',0)
->orderBy('created_at', 'desc')
->get();

  $prescriptions = DB::table('appointments')
  ->Join('prescriptions', 'appointments.id', '=', 'prescriptions.appointment_id')
  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
 ->select('facilities.FacilityName','doctors.name as docname','prescriptions.created_at','prescriptions.filled_status'
  ,'prescriptions.id as prescid')
 ->where('appointments.afya_user_id', '=',$afyauserId)
   ->orderBy('prescriptions.created_at', 'desc')
    ->get();

}else {
  $prescriptions = DB::table('appointments')
  ->Join('prescriptions', 'appointments.id', '=', 'prescriptions.appointment_id')
  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
 ->select('facilities.FacilityName','doctors.name as docname','prescriptions.created_at','prescriptions.filled_status'
  ,'prescriptions.id as prescid')
 ->Where('appointments.persontreated', '=',$dependantId)
   ->orderBy('prescriptions.created_at', 'desc')
    ->get();
}
?>
<div class="col-lg-12">
<div class="ibox float-e-margins">
<div class="ibox-content">
<h5>Prescription History</h5>
<div class="ibox-content">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-conditional" >
<thead>
  <tr>
    <th></th>
    <th>Date </th>
    <th>Facility</th>
    <th>Doctor</th>
   <th>Action</th>
  </tr>
</thead>

<tbody>
<?php $i =1;   ?>
  @foreach($prescriptions as $tstdn)
  <tr>
  <td>{{ +$i }}</td>
  <td>{{$tstdn->created_at}}</td>
  <td>{{$tstdn->FacilityName}}</td>
  <td>{{$tstdn->docname}}</td>
  <td><a href="{{route('prscdetails2',$tstdn->prescid)}}">View</a></td>
  </tr>
  <?php $i++; ?>

  @endforeach


</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>


</div>
</div>
</div>


 </div>



              <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <h4 class="modal-title">Coming Soon</h4>
                                        <!-- <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small> -->
                                    </div>
                                    <div class="modal-body">
                                    <!-- <div class="col-sm-5 b-r">
                                        <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                                            printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
                                            remaining essentially unchanged.</p>
                                    </div> -->
                                     <!-- <div class="col-sm-5">
                                        <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                                            printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
                                            remaining essentially unchanged.</p>
                                      </div> -->
                                    </div>
                         <div class="ibox float-e-margins">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>




       </div>
    </div>

<script>
function insert_presc_detail(detail_id,prescription,strength){
  $.ajax({
                    url     : "{{ url('/insert-presc-detail')}}",
                    method  : 'post',
                    data    : {
                        state:'Normal',
                        appointment_id:'{{$app_id}}',
                        doc_id:'{{$doc_id}}',
                        afya_user_id:'{{$afyauserId}}',
                        dependant_id:'{{$dependantId}}',
                        facility_id:'{{$fac_id}}',
                        prescription:prescription,
                        strength:strength,
                        disease_id:$('#disease_id'+prescription).val(),
                        routes:$('#routes'+prescription).val(),
                        frequency:$('#frequency'+prescription).val()
                    },
                    headers:
                    {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function(response){

                      $('.p'+prescription).html('<button class="btn btn-danger" ype="button" onClick="delete_presc_detail({{$detail_id}})"><span class="glyphicon glyphicon-minus"></span>REMOVE</button>');
                    }
                });

    }


   function delete_presc_detail(detail_id,prescription){


                $.ajax({
                    url     : "{{ url('/delete-presc-detail')}}",
                    method  : 'post',
                    data    : {
                        id:detail_id
                    },
                    headers:
                    {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function(response){

                      $('.p'+prescription).html('<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-plus"></span>ADD</button>');
                    }
                });

    }




</script>


@endsection
<!-- Section Body Ends-->
@section('script-test')

<!-- Put your scripts here -->

@endsection
