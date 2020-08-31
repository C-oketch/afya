@extends('layouts.doctor_layout')
@section('title', 'Patient History')
@section('content')
<?php
$doc = (new \App\Http\Controllers\DoctorController);
$Docdatas = $doc->DocDetails();
foreach($Docdatas as $Docdata){
$Did = $Docdata->id;
$Name = $Docdata->name;

}
if($user->persontreated == 'Self'){
  $name = $user->firstname ." ". $user->secondName;
  $gender = $user->gender;
  $age = $user->dob;
  $app_id = $user->appid;
  // $app_id = $user->appid;
}else{

$name = $user->name1 ." ". $user->name2;
$gender = $user->depgender;
$age = $user->depdob;
}
$interval = date_diff(date_create(), date_create($age));
$age= $interval->format(" %Y Years, %M Months Old");


?>
@section('leftmenu')
@include('includes.doc_inc.leftmenu')
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-8">
                  <h2>PATIENT</h2>
                  <ol class="breadcrumb">
                      <li>
                          <a href="#">  <strong>Name:</strong> {{$name}}</a>
                      </li>
                      <li>
                          <strong>Gender:</strong> {{$gender}}<br>

                      </li>
                      <li class="active">
                          <strong>Age:</strong> {{$age}}
                      </li>
                  </ol>
              </div>
              <div class="col-lg-4">
                  <div class="title-action">
                      <!-- <a href="#" class="btn btn-white"><i class="fa fa-pencil"></i> Edit </a>
                      <a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save </a> -->
                      <a href="{{url('allpatientsDOC')}}"  class="btn btn-primary"><i class="fa fa-angle-double-left"></i> Back </a>
                  </div>
              </div>
          </div>
<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">

            <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>VISIT SUMMARY</h5>

                </div>
                <div class="ibox-content">

                    <!-- <form id="form" action="#"> -->

                    <div id="wizard"  class="wizard-big">
                      @if($ptdetails)
                        <h1>Triage</h1>
                        <div class="step-content">
                            <div class="text-center m-t-md">

                            <div class="col-sm-6 b-r">
                              <form class="form-horizontal">
                                    <div class="form-group"><label class="col-lg-3 control-label">Weight (kg)</label>
                                         <div class="col-lg-6">
                                       <input type="text" value="{{$ptdetails->current_weight}}" class="form-control" readonly ></div>
                                    </div>
                                    <div class="form-group"><label class="col-lg-3 control-label">Height (cm)</label>
                                         <div class="col-lg-6">
                                       <input type="text" value="{{$ptdetails->current_height}}" class="form-control" readonly ></div>
                                    </div>
                                    <div class="form-group"><label class="col-lg-3 control-label">Temperature (°C)</label>
                                         <div class="col-lg-6">
                                       <input type="text" value="{{$ptdetails->temperature}}" class="form-control" readonly ></div>
                                    </div>

                                </form>
                            </div>

                            <div class="col-sm-6"><h4></h4>
                              <form class="form-horizontal">
                   <div class="form-group"><label class="col-lg-3 control-label">Systolic BP</label>
                                    <div class="col-lg-6">
                                  <input type="text" value="{{$ptdetails->systolic_bp}}" class="form-control" readonly ></div>
                               </div>
                               <div class="form-group"><label class="col-lg-3 control-label">Diastolic BP</label>
                                    <div class="col-lg-6">
                                  <input type="text" value="{{$ptdetails->diastolic_bp}}" class="form-control" readonly ></div>
                               </div>
                               <?php $height=$ptdetails->current_height;
                               $height=($height/100);
                                $weight=$ptdetails->current_weight;
                                if($height){
                                  $bmi =$weight/($height*$height);
                                }else{
                                  $bmi =00;
                                }


                                     ?>
                                     <div class="form-group"><label class="col-lg-3 control-label">BMI</label>
                                          <div class="col-lg-6">
                                        <input type="text" value="<?php echo number_format($bmi, 2); ?>" class="form-control" readonly ></div>
                                     </div>
                            </form>
                            </div>
                            </div>
                        </div>
                        @endif


                        <h1>Test Details</h1>
                        <div class="step-content">
                            <div class="text-center m-t-md">
                              <div class="ibox-content">
                                <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover visits" >
                              <thead>
                                                      <tr>
                                                          <th>No</th>
                                                          <th>Test Name</th>
                                                          <th>Category</th>
                                                          <th>Date Created</th>
                                                          <th>Action</th>

                                                        </tr>
                                                  </thead>
                                                <tbody>
                                                  <?php $i = 1; ?>

                                                  @foreach($tsts as $tst)
                                                  @if($tst->tname)

                                                    <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$tst->tname}}</td>
                                                    <td>{{$tst->tsname}}</td>
                                                    <td>{{$tst->date}}</td>

                                   @if($tst->done==1)
                                             <td class="btn btn-primary">  <a href="{{route('view_testdoc',$tst->patTdid)}}">View Test</a></td>
                                             @else
                                             <td class="btn btn-primary">  Pending</td>
                                    @endif

                                              @endif

                                                   </tr>
                                                  <?php $i++; ?>
                                                    @endforeach


                                             <?php $i = $i;

                                             if($rady){
                                             ?>

                                             @foreach($rady as $radst)
                                             <?php
                                             if ($radst->test_cat_id== '9') {
                                               $ct=DB::table('ct_scan')->where('id', '=',$radst->test) ->first();
                                               $test = $ct->name;
                                               $type ='donectdoc';


                                             } elseif ($radst->test_cat_id== 10) {
                                               $xray=DB::table('xray')->where('id', '=',$radst->test) ->first();
                                               $test = $xray->name;
                                               $type ='donexraydoc';
                                             } elseif ($radst->test_cat_id== 11) {
                                               $mri=DB::table('mri_tests')->where('id', '=',$radst->test)->first();
                                               $test = $mri->name;
                                               $type ='donemridoc';
                                             }elseif ($radst->test_cat_id== 12) {
                                               $ultra=DB::table('ultrasound')->where('id', '=',$radst->test) ->first();
                                               $test = $ultra->name;
                                               $type ='doneultradoc';

                                           }elseif ($radst->test_cat_id== 13) {
                                             $other=DB::table('other_tests')->where('id', '=',$radst->test) ->first();
                                             $test = $other->name;
                                             $type ='doneotherdoc';
                                           }

                                             ?>
                                               <tr>
                                               <td>{{$i}}</td>
                                               <td>{{$test}}</td>
                                               <td>{{$radst->tcname}}</td>
                                               <!-- <td>{{$radst->clinicalinfo}}</td> -->
                                               <td>{{$radst->date}}</td>
                                                @if($radst->done==1)
                                                <td class="btn btn-primary">Pending</td>
                                               @else
                                                <td class="btn btn-primary"><a href="{{route($type,$radst->patTdid)}}">View Test</a> </td>
                                               @endif

                                             </tr>
                                             <?php $i++; ?>
                                               @endforeach
                                             <?php } ?>

                                                   </tbody>
                                            </table>

                                                     </div>

                                                 </div>
                            </div>
                        </div>

                        @if($diagnosis)
                        <h1>Diagnosis</h1>
                        <div class="step-content">
                            <div class="text-center m-t-md">
                              <div class="table-responsive ibox-content">
                              <table class="table table-striped table-bordered table-hover visits" >
                              <thead>
                                <tr>
                                  <th></th>
                                  <th>Date Diagnosed</th>
                                  <th>Condition</th>
                                  <th>Facility</th>
                                </tr>
                              </thead>

                              <tbody>
                              <?php $i =1; ?>

                              @foreach($diagnosis as $diag)
                              <tr>
                              <td>{{ +$i }}</td>
                              <td>{{$diag->date_diagnosed}}</td>
                              <td>{{$diag->name}}</td>
                              <td>{{$diag->FacilityName}}</td>
                              </tr>
                              <?php $i++; ?>

                              @endforeach

                              </tbody>
                              </table>
                              </div>
                            </div>
                        </div>
                        @endif
                        @if($prescriptions)
                      <h1>Prescriptions</h1>
                        <div class="step-content">
                            <div class="text-center m-t-md">
                              <div class="table-responsive ibox-content">
                              <table class="table table-striped table-bordered table-hover visits" >
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Drug</th>
                                  <th>Substituted By</th>
                                  <th>Start Date</th>
                                  <th>End Date</th>
                                  <th>Dose Given</th>
                                  <th>Quantity</th>
                                  <th>Strength</th>
                                  <th>Routes</th>
                                  <th>Frequency</th>
                                  <th>Pharmacy</th>

                                </tr>
                              </thead>

                              <tbody>
                              <?php $i =1; ?>

                              @foreach($prescriptions as $tstdn)
                              <?php
                           if($tstdn->substitute_presc_id)	{
                        $subdrug=DB::table('druglists')->select('drugname')->where('id',$tstdn->subdrug_id)
                         ->first();     }

                               ?>
                              <tr>
                              <td>{{ +$i }}</td>
                              <td>{{$tstdn->drugname}}</td>
                              <td>@if($tstdn->substitute_presc_id){{$subdrug->drugname}} @else None @endif</td>
                              <td>{{$tstdn->start_date}}</td>
                              <td>{{$tstdn->end_date}}</td>
                              <td>{{$tstdn->dose_given}}</td>
                              <td>{{$tstdn->quantity}}</td>
                       @if($tstdn->substitute_presc_id)
                              <td>{{$tstdn->substrength}}  {{$tstdn->substrength_unit}}</td>
                              <td>{{$tstdn->subroutes}}</td>
                               <td>{{$tstdn->subfrequency}}</td>
                       @else
                               <td>{{$tstdn->strength}}  {{$tstdn->strength_unit}}</td>
                               <td>{{$tstdn->routes}}</td>
                               <td>{{$tstdn->frequency}}</td>
                       @endif
                         <td>{{$tstdn->pharmacy}}</td>
                              </tr>
                              <?php $i++; ?>

                              @endforeach

                              </tbody>
                              </table>
                              </div>
                            </div>
                        </div>
                        @endif
                        @if($procedures)


                        <h1>Procedures</h1>
                        <div class="step-content">
                            <div class="text-center m-t-md">
                              <div class="table-responsive ibox-content">
                              <table class="table table-striped table-bordered table-hover visits" >
                              <thead>
                                <tr>
                                  <th></th>
                                  <th>Procedure Date</th>
                                  <th>Condition</th>
                                  <th>Notes</th>
                                  <th>Facility</th>
                                </tr>
                              </thead>

                              <tbody>
                              <?php $i =1; ?>

                              @foreach($procedures as $proc)
                              <tr>
                              <td>{{ +$i }}</td>
                              <td>@if($proc->procedure_date){{$proc->procedure_date}}@else Not Set @endif</td>
                              <td>{{$proc->description}}</td>
                              <td>{{$proc->notes}}</td>
                              <td>{{$proc->FacilityName}}</td>
                              </tr>
                              <?php $i++; ?>

                              @endforeach

                              </tbody>
                              </table>
                              </div>
                            </div>
                        </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>
        </div>
</div>

    @endsection
    @section('script-test')
    <script>
    $(document).ready(function() {
    // Smart Wizard
    $("#wizard").steps();
   });
</script>
    <script>


    $(document).ready(function(){
            $('.visits').DataTable({
                pageLength: 100,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script>

@endsection
