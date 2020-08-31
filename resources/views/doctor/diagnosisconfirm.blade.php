@extends('layouts.doctor_layout')
@section('title', 'Diagnosis')
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

   $stat= $pdetails->status;
   $afyauserId= $pdetails->afya_user_id;
    $dependantId= $pdetails->persontreated;
    $app_id_prev= $pdetails->last_app_id;
    $app_id =  $pdetails->id;
    $doc_id= $pdetails->doc_id;
    $fac_id= $pdetails->facility_id;
    $fac_setup = $pdetails->set_up;
    $condition = $pdetails->condition;
    $dependantAge = $pdetails->depdob;

if($app_id_prev){ $app_id2 = $app_id_prev;}else{$app_id2 = $app_id;}

if ($dependantId =='Self') {
      $dob=$pdetails->dob;
      $gender=$pdetails->gender;
    $firstName = $pdetails->firstname;
    $secondName = $pdetails->secondName;
    $name =$firstName." ".$secondName;
}

else {
     $dob = $pdetails->depdob;
     $gender=$pdetails->depgender;
     $firstName = $pdetails->dep1name;
     $secondName = $pdetails->dep2name;
     $name =$firstName." ".$secondName;
}
$now = time(); // or your date as well
$your_date = strtotime($dependantAge);
$datediff = $now - $your_date;
$dependantdays= floor($datediff / (60 * 60 * 24));
$interval = date_diff(date_create(), date_create($dob));
$age= $interval->format(" %Y Years Old");
}

?>


     <!--tabs Menus-->
     @section('leftmenu')
     @include('includes.doc_inc.leftmenu2')
     @endsection
     @include('includes.doc_inc.topnavbar_v2')



   <div class="row wrapper border-bottom white-bg page-heading">


                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                      <div class="invoice-title">
                        <!-- <h2>Invoice</h2><h3 class="pull-right">Invoice #</h3> -->
                      </div>
                      <!-- <hr> -->
                      <br /><br />
                    <div class="col-md-6">
                      <address>
                      <strong>Patient:</strong><br>
                       Name: {{$name}}<br>
                       Gender: {{$gender}}<br>
                       Age: {{$age}}
                      </address>

                    </div>
                    <div class="col-md-6 text-right">
                      <address>
                        <strong>Requested By :</strong><br>
                        {{$Name}}<br>
                       {{$pdetails->FacilityName}} <br>
                      </address>

                    </div>
                  </div>
                  </div>

<?php $i=1; $fhDeta=DB::table('patient_test_details')
   ->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
   ->Join('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
   ->Join('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
   ->select('tests.name','appointment_id','patient_test_details.tests_reccommended','test_subcategories.name as subname','test_categories.name as catname')
   ->where('patient_test_details.id', '=',$patientT->ptdid)
   ->first();
?>

<div class="row">
  <div class="col-md-10">
  <h3 class="text-center">{{$fhDeta->catname}}</h3>
  <a class="btn btn-primary pull-right"  href="{{url('test-all',$app_id)}}"><i class="fa fa-angle-double-left"></i>&nbsp;BACK</a>

  <div class="text-center">
    {{$fhDeta->subname}}
    </div>
   </div>
 </div>


 <!-- <div class="ibox-title">
   <h5>TEST RESULTS</h5>
   <div class="ibox-tools">
     <a class="btn btn-primary"  href="{{url('test-all',$app_id)}}"><i class="fa fa-angle-double-left"></i>&nbsp;BACK</a>
   </div>
 </div> -->
 <!--test Results------------------------------------------------------------------>

 <?php $i=1; $fhb=DB::table('test_ranges')
 ->leftJoin('test_results', 'test_ranges.id', '=', 'test_results.test_ranges_id')
 ->leftJoin('tests', 'test_ranges.tests_id', '=', 'tests.id')
 ->select('test_results.*','test_results.value','tests.name')
 ->where('test_results.ptd_id', '=',$patientT->ptdid)
 ->first(); ?>

 <?php $i=1; $fh=DB::table('test_results')
->leftJoin('test_ranges', 'test_results.test_ranges_id', '=', 'test_ranges.id')
 ->leftJoin('tests', 'test_ranges.tests_id', '=', 'tests.id')
 ->select('test_results.value','test_results.units as runit','test_results.result_name as rname',
 'test_results.reason as rreason',
 'tests.name as tname','test_ranges.*')
 ->where([['test_results.ptd_id', '=',$patientT->ptdid],
          ])
 ->get(); ?>

@if($fh)
 <div class="row">
 <div class="col-md-10 col-md-offset-1">
   <div class="panel panel-default">
     <div class="panel-heading">
       <h3 class="panel-title"><strong>{{$fhDeta->name}} Test</strong></h3>
     </div>
     <div class="panel-body">
       <div class="table-responsive">
         <table class="table table-condensed">
           <thead>
                           <tr>
                 <td><strong>#</strong></td>
                 <td><strong>TEST</strong></td>
                 <td><strong>VALUE</strong></td>
                 <td><strong>UNITS</strong></td>
                <td>@if($gender == 'Male')<strong>NORMAL MALE</strong> @else<strong>NORMAL FEMALE</strong></td> @endif

                  </tr>
             </thead>
           <tbody>


             @foreach($fh as $fhtest)
             <tr>
             <td>{{$i}}</td>
             <td>@if($fhtest->tname){{$fhtest->tname}}@else{{$fhtest->rname}}@endif</td>
             <td>{{$fhtest->value}}</td>
             <td>@if($fhtest->runit){{$fhtest->runit}}@else{{$fhtest->units}} @endif</td>
             @if($gender == 'Male')
             <td>{{$fhtest->low_male}} - {{$fhtest->high_male}}</td>
              @else
             <td>{{$fhtest->low_female}} - {{$fhtest->high_female}}</td>
              @endif

             <?php $i ++ ?>
             </tr>
             @endforeach

           </tbody>
         </table>
       </div>
     </div>
   </div>
 </div>
 </div>
 <!--Interpretations------------------------------------------------------------------------->
 <?php $i=1; $fh2=DB::table('tests')
 ->Join('test_ranges', 'tests.id', '=', 'test_ranges.tests_id')
 ->Join('test_interpretations', 'test_ranges.id', '=', 'test_interpretations.test_ranges_id')
 ->where('tests.id', '=',$fhDeta->tests_reccommended)
 ->select('test_interpretations.*')
 ->get(); ?>
   @if($fh2)
   <div class="row">
   	<div class="col-md-10 col-md-offset-1">
   		<div class="panel panel-default">
   			<div class="panel-heading">
   				<h3 class="panel-title"><strong>Test Interpretation</strong></h3>
   			</div>
   			<div class="panel-body">
   				<div class="table-responsive">
   					<table class="table table-condensed">
   						<thead>
   									<tr>
   									<td class="text-center"><strong>#</strong></td>
   									<td class="text-center"><strong>VALUE</strong></td>
   									<td class="text-center"><strong>INTERPRETATIONS</strong></td>
   									</tr>

   						</thead>
   						<tbody>
   							@foreach($fh2 as $fhtest)
   				 	   <tr>
                <td class="thick-line text-center">{{$i}}</td>
                <td class="thick-line text-center">{{$fhtest->value}}</td>
                <td class="thick-line text-center">{{$fhtest->description}}</td>
               <?php $i ++ ?>
   				 		 </tr>
   				 		 @endforeach
                </tbody>
   					</table>
   				</div>
   			</div>
   		</div>
   	</div>
   </div>
  @endif
  <!--Comments------------------------------------------------------------------------->
  <div class="row">
  <div class="col-md-10 col-md-offset-1">
  <div class="panel panel-default">
  <div class="panel-heading">
  <h3 class="panel-title"><strong>Comments:</strong></h3>
  <br />
  <p>Results : {{$patientT->results}}</p>
  <br />
  	<p>Other Comments : {{$patientT->note}}</p>
  </div>
  </div>
  </div>
  </div>


  <!--Confirm Diagnosis------------------------------------------------------------------>


  <div class="row">
   <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-primary">
          <div class="panel-heading">
           CONFIRM TEST RESULTS
          </div>
          <div class="panel-body">
            <div class="form-group"><label class="col-md-2 control-label">TEST RESULT IS ?</label>
               <div class="col-md-10">
                <label class="checkbox-inline"><input type="checkbox" id="Positive1">Positive</label>
                <label class="checkbox-inline"><input type="checkbox" id="Negative1">Negative</label>
             </div>
            </div>
             <div id="negative" class="ficha">
            {{ Form::open(array('route' => array('Testconfirms'),'method'=>'POST')) }}
                <input type="hidden" name="appid" value="{{$app_id}}" class="form-control" >
                <input type="hidden" name="ptdid" value="{{$patientT->ptdid}}" class="form-control" >
            <button class="btn btn-primary btn-lg btn-block" type="submit" ><i class="fa fa-flask"></i>DONE</button>
            {{ Form::close() }}
            </div>

            <div id="positive" class="ficha">
              {{ Form::open(array('route' => array('confdiag'),'method'=>'POST')) }}
     <div class="form-group">
                <label>Disease Name:</label>
     <select id="diseases" name="disease" multiple="multiple" class="form-control d_list2" style="width: 100%"></select>
       </div>

                  <input type="hidden" name="ptdid" value="{{$patientT->ptdid}}" class="form-control" >


                  <div class="form-group">
                  <label for="tag_list" class="">Type of Diagnosis:</label>
                  <select class="select2_demo_1" name="level"  style="width: 100%" >
                  <option value=''>Choose one</option>
                  <option value='Primary'>Primary</option>
                  <option value='Secondary'>Secondary</option>
                  </select>
                  </div>
                  <div class="form-group">
                  <label for="tag_list" class="">Chronic:</label>
                  <select class="select2_demo_1" name="chronic"  style="width: 100%" >
                  <option value=''>Choose one</option>
                  <option value='Y'>YES</option>
                  <option value='N'>No</option>
                  </select>
                  </div>



                   {{ Form::hidden('state','Normal', array('class' => 'form-control')) }}
                 {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}

                   {{ Form::hidden('dependant_id',$dependantId, array('class' => 'form-control')) }}
                   {{ Form::hidden('afya_user_id',$afyauserId, array('class' => 'form-control')) }}
                   {{ Form::hidden('facility_id',$fac_id, array('class' => 'form-control')) }}
                   {{ Form::hidden('doc_id',$Did, array('class' => 'form-control')) }}

             <div class="col-md-offset-5">
               <button class="btn btn-lg btn-primary  m-t-n-xs" type="submit"><strong>Submit</strong></button>
             {{ Form::close() }}
           </div>
           </div>
          </div>
      </div>
  </div>

 </div>
 <!-- end diagnosis -->
@else

<div class="col-md-12">
          <div class="ibox float-e-margins">

              <div class="ibox-title">
                <h5>TEST RESULTS</h5>
                <div class="ibox-tools">
                  <a class="btn btn-primary"  href="{{url('test-all',$app_id)}}"><i class="fa fa-angle-double-left"></i>&nbsp;BACK</a>
                </div>
              </div>
        <div class="ibox-content">
                <h3 class="text-center"></h3>
                  <div class="list-group">
                    {{ Form::open(array('route' => array('doc.labtest'),'method'=>'POST')) }}
                          <div class="col-md-10">
                          <div class="form-group">
                            <label>TEST:</label>
                            <input type="text" name="radiology" value="{{$fhDeta->name}}" class="form-control" readonly/>
                          </div>
                    <div class="form-group">
                               <label>Results :</label></br>
                               <textarea rows="6" name="note" cols="100"></textarea>
                             </div>
                           {{ Form::hidden('appointment',$app_id, array('class' => 'form-control')) }}
                           {{ Form::hidden('ptdid',$patientT->ptdid, array('class' => 'form-control')) }}
                           {{ Form::hidden('ptid',$patientT->ptid, array('class' => 'form-control')) }}
                           {{ Form::hidden('test',$patientT->ptest, array('class' => 'form-control')) }}

                           </div>
                           <div class="col-md-12">
                           <button class=" mtop btn btn-sm btn-primary  m-t-n-xs" type="submit"><strong>Submit</strong></button>
                           </div>

                           {{ Form::close() }}
              </div>
          </div>
      </div>
    </div>







@endif



@endsection
@section('script-test')
<script>
$(".select2_demo_1").select2();
</script>
<script>
$(document).ready(function(){
    $('#Positive1').change(function(){
        if(this.checked)
            $('#positive').fadeIn('slow');
            $('#negative').hide('fast');
    });
    $('#Negative1').change(function(){
        if(this.checked)
            $('#negative').fadeIn('slow');
            $('#positive').hide('fast');
    });
});
</script>


@endsection
