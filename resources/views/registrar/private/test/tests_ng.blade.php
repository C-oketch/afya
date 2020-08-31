@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('style')

@endsection
@section('content')
@include('includes.registrar.topnavbar_v2')
<?php


$app_id = $appdetails->id;
$afyauserId= $user->id;
$facd = $path->facilitycode;
// laboratory tests
$tests = DB::table('tests')
->Join('test_price', 'tests.id', '=', 'test_price.tests_id')
->Join('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
->Join('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
->select('tests.id as testId','tests.name as tname','test_subcategories.name as subname',
'test_categories.name as cname')
->where('test_price.facility_id',$facd)
->get();

$cardiac = DB::table('tests_cardiac')
->Join('testprice_cardiac', 'tests_cardiac.id', '=', 'testprice_cardiac.tests_id')
->select('tests_cardiac.id as testId','tests_cardiac.name as tname')
->where('testprice_cardiac.facility_id',$facd)
->get();

$neurology = DB::table('tests_neurology')
->Join('testprice_neurology', 'tests_neurology.id', '=', 'testprice_neurology.tests_id')
->select('tests_neurology.id as testId','tests_neurology.name as tname')
->where('testprice_neurology.facility_id',$facd)
->get();

$procedurec = DB::table('procedures')
->Join('procedure_prices', 'procedures.id', '=', 'procedure_prices.procedure_id')
->select('procedures.id','procedures.name')
->where('procedure_prices.facility_id',$facd)
->where('procedures.category','Cardiac')
->get();

$proceduren = DB::table('procedures')
->Join('procedure_prices', 'procedures.id', '=', 'procedure_prices.procedure_id')
->select('procedures.id','procedures.name')
->where('procedure_prices.facility_id',$facd)
->where('procedures.category','Neurology')
->get();

  $xraytests = DB::table('xray')
->Join('test_prices_xray', 'xray.id', '=', 'test_prices_xray.xray_id')
->where('test_prices_xray.facility_id',$facd)
->select('xray.id','xray.name')
->orderBy('status', 'desc')
->get();

$mritests = DB::table('mri_tests')
->Join('test_prices_mri', 'mri_tests.id', '=', 'test_prices_mri.mri_id')
->select('mri_tests.id','mri_tests.name')
->where('test_prices_mri.facility_id',$facd)
->orderBy('status', 'desc')
->get();


$ultrasound = DB::table('ultrasound')
->Join('test_prices_ultrasound', 'ultrasound.id', '=', 'test_prices_ultrasound.ultrasound_id')
->select('ultrasound.id','ultrasound.name')
->where('test_prices_ultrasound.facility_id',$facd)
->orderBy('status', 'desc')->get();

$ctscan = DB::table('ct_scan')
->Join('test_prices_ct_scan', 'ct_scan.id', '=', 'test_prices_ct_scan.ct_scan_id')
->select('ct_scan.id','ct_scan.name')
->where('test_prices_ct_scan.facility_id',$facd)
->orderBy('status', 'desc')->get();

$othertests = DB::table('other_tests')
->Join('test_prices_other', 'other_tests.id', '=', 'test_prices_other.other_id')
->where('test_prices_other.facility_id',$facd)
->select('other_tests.id','other_tests.name','other_tests.test_cat_id')
->orderBy('status', 'desc')
->get();
?>
<div class="container">
<div class="row">
<div class="col-md-11">
<div class="ibox float-e-margins">
<div class="tab" role="tabpanel">
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
<li role="presentation" class=""><a href="{{ URL('registrar.shows2', $app_id) }}" aria-controls="home" role="tab" >BASIC DETAILS</a></li>
<li role="presentation" class="active"><a href="{{ URL('registrar.shows_test', $app_id) }}" aria-controls="profile" role="tab" >PATIENT TESTS</a></li>
<li role="presentation" class=""><a href="{{ URL('registrar.shows_pay', $app_id) }}" aria-controls="messages" role="tab">PAYMENTS</a></li>
</ul>

</div>
</div>
</div>
</div>

<div class="ibox-content">
    <div class="row">
      <div class="col-md-11">
{!! Form::open(array('url' => 'reg.savelab','method'=>'POST')) !!}
 <input type="hidden" name="_token" value="{{ csrf_token() }}">
 <input type="hidden" class="form-control"  name="appointment" value="{{$app_id}}" >

  <div class="col-sm-12">

    <div class="form-group">
    <label>Cardic Tests</label>
    <select class="form-control m-b select2_demo_1"  name="cardiac[]" multiple>
      @foreach ($cardiac as $card)
      <?php

      $datacard = DB::table('patient_test_details_c')
      ->Join('appointments', 'patient_test_details_c.appointment_id', '=', 'appointments.id')
      ->select('patient_test_details_c.id','appointments.id as appp')
      ->Where([['patient_test_details_c.tests_reccommended',$card->testId],
              ['appointments.afya_user_id',$afyauserId],
              ['patient_test_details_c.done',0],
              ['patient_test_details_c.deleted',0],
              ['patient_test_details_c.status','=',0],
            ])
      ->first();
      ?>
      <option value="{{$card->testId}} "  @if($datacard) disabled   @endif>{{$card->tname}}</option>
      @endforeach
     </select>
     </div>

     <div class="form-group">
     <label>laboratory Tests</label>
     <select class="form-control m-b select2_demo_1"  name="lab[]" multiple="multiple">
       <option value="" disabled selected >Please select one</option>
   @foreach ($tests as $tsts)
   <?php
   $datadetailsl = DB::table('patient_test_details')
   ->Join('appointments', 'patient_test_details.appointment_id', '=', 'appointments.id')
   ->select('patient_test_details.id','appointments.id as appp')
   ->Where([['patient_test_details.tests_reccommended',$tsts->testId],
           ['appointments.afya_user_id',$afyauserId],
           ['patient_test_details.done',0],
           ['patient_test_details.deleted',0],
           ['patient_test_details.status','=',0],
         ])
   ->first();
   ?>
       <option value="{{$tsts->testId}}"  @if($datadetailsl) disabled   @endif>{{$tsts->tname}}</option>
       @endforeach
      </select>
      </div>

      <div class="form-group">
      <label>Neurology Tests</label>
      <select class="form-control m-b select2_demo_1"  name="neurology[]" multiple>

        @foreach ($neurology as $neuro)
        <?php
        $dataneuro = DB::table('patient_test_details_n')
        ->Join('appointments', 'patient_test_details_n.appointment_id', '=', 'appointments.id')
        ->select('patient_test_details_n.id','appointments.id as appp')
        ->Where([['patient_test_details_n.tests_reccommended',$neuro->testId],
                ['appointments.afya_user_id',$afyauserId],
                ['patient_test_details_n.done',0],
                ['patient_test_details_n.deleted',0],
                ['patient_test_details_n.status','=',0],
              ])
        ->first();
        ?>
        <option value="{{$neuro->testId}} "  @if($dataneuro) disabled   @endif>{{$neuro->tname}}</option>
        @endforeach
       </select>
       </div>

<div class="ibox float-e-margins">
<div class="ibox-title">
<h5>Radiology Test</h5>
</div>
<div class="ibox-content">
   <div class="form-group">
   <label>X-Ray Tests</label>
   <select class="form-control m-b select2_demo_1"  name="xray[]" multiple>

     @foreach ($xraytests as $xrayt)
     <?php

     $dataxray = DB::table('radiology_test_details')
     ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
     ->select('radiology_test_details.id','appointments.id as appp')
     ->Where([['radiology_test_details.test',$xrayt->id],
             ['appointments.afya_user_id',$afyauserId],
             ['radiology_test_details.done',0],
             ['radiology_test_details.test_cat_id',10],
             ['radiology_test_details.deleted',0],
             ['radiology_test_details.status','=',0],
           ])
     ->first();
     ?>
     <option value="{{$xrayt->id}} "  @if($dataneuro) disabled   @endif>{{$xrayt->name}}</option>
     @endforeach
    </select>
    </div>


    <div class="form-group">
    <label>MRI Tests</label>
    <select class="form-control m-b select2_demo_1"  name="mri[]" multiple>

      @foreach ($mritests as $mri)
      <?php

      $datamri = DB::table('radiology_test_details')
      ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
      ->select('radiology_test_details.id','appointments.id as appp')
      ->Where([['radiology_test_details.test',$mri->id],
              ['appointments.afya_user_id',$afyauserId],
              ['radiology_test_details.done',0],
              ['radiology_test_details.test_cat_id',11],
              ['radiology_test_details.deleted',0],
              ['radiology_test_details.status','=',0],
            ])
      ->first();
      ?>
      <option value="{{$mri->id}} "  @if($datamri) disabled   @endif>{{$mri->name}}</option>
      @endforeach
     </select>
     </div>

     <div class="form-group">
     <label>Ultrasound Tests</label>
     <select class="form-control m-b select2_demo_1"  name="ultra[]" multiple>

       @foreach ($ultrasound as $ultra)
       <?php

       $dataultra = DB::table('radiology_test_details')
       ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
       ->select('radiology_test_details.id','appointments.id as appp')
       ->Where([['radiology_test_details.test',$ultra->id],
               ['appointments.afya_user_id',$afyauserId],
               ['radiology_test_details.done',0],
               ['radiology_test_details.test_cat_id',12],
               ['radiology_test_details.deleted',0],
               ['radiology_test_details.status','=',0],
             ])
       ->first();
       ?>
       <option value="{{$ultra->id}} "  @if($dataultra) disabled   @endif>{{$ultra->name}}</option>
       @endforeach
      </select>
      </div>

      <div class="form-group">
      <label>Ct-Scan Tests</label>
      <select class="form-control m-b select2_demo_1"  name="ctscan[]" multiple>

        @foreach ($ctscan as $cts)
        <?php

        $datacts = DB::table('radiology_test_details')
        ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
        ->select('radiology_test_details.id','appointments.id as appp')
        ->Where([['radiology_test_details.test',$cts->id],
                ['appointments.afya_user_id',$afyauserId],
                ['radiology_test_details.done',0],
                ['radiology_test_details.test_cat_id',9],
                ['radiology_test_details.deleted',0],
                ['radiology_test_details.status','=',0],
              ])
        ->first();
        ?>
        <option value="{{$cts->id}} "  @if($datacts) disabled   @endif>{{$cts->name}}</option>
        @endforeach
       </select>
       </div>



       <div class="form-group">
       <label>Other Tests</label>
       <select class="form-control m-b select2_demo_1"  name="othert[]" multiple>

         @foreach ($othertests as $other)
         <?php

         $dataother = DB::table('radiology_test_details')
         ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
         ->select('radiology_test_details.id','appointments.id as appp')
         ->Where([['radiology_test_details.test',$other->id],
                 ['appointments.afya_user_id',$afyauserId],
                 ['radiology_test_details.done',0],
                 ['radiology_test_details.test_cat_id',13],
                 ['radiology_test_details.deleted',0],
                 ['radiology_test_details.status','=',0],
               ])
         ->first();
         ?>
         <option value="{{$other->id}} "  @if($dataother) disabled   @endif>{{$other->name}}</option>
         @endforeach
        </select>
        </div>

</div>
</div>

<div class="ibox float-e-margins">
<div class="ibox-title">
<h5>Procedures Test</h5>
</div>
<div class="ibox-content">
  <div class="form-group">
  <label>Cardiac Procedures</label>
  <select class="form-control m-b select2_demo_1"  name="pcardiac[]" multiple>

    @foreach ($procedurec as $procc)
    <?php
    $dataprocc = DB::table('patient_procedure_details')
    ->Join('appointments', 'patient_procedure_details.appointment_id', '=', 'appointments.id')
    ->select('patient_procedure_details.id','appointments.id as appp')
    ->Where([['patient_procedure_details.procedure_id',$procc->id],
            ['appointments.afya_user_id',$afyauserId],
            ['patient_procedure_details.done',0],
            ['patient_procedure_details.deleted',0],
            ['patient_procedure_details.status','=',0],
          ])
    ->first();
    ?>
    <option value="{{$procc->id}} "  @if($dataprocc) disabled   @endif>{{$procc->name}}</option>
    @endforeach
   </select>
   </div>

   <div class="form-group">
   <label>Neurology Procedures</label>
   <select class="form-control m-b select2_demo_1"  name="pneurology[]" multiple>

     @foreach ($proceduren as $procn)
     <?php
     $dataprocn = DB::table('patient_procedure_details')
     ->Join('appointments', 'patient_procedure_details.appointment_id', '=', 'appointments.id')
     ->select('patient_procedure_details.id','appointments.id as appp')
     ->Where([['patient_procedure_details.procedure_id',$procc->id],
             ['appointments.afya_user_id',$afyauserId],
             ['patient_procedure_details.done',0],
             ['patient_procedure_details.deleted',0],
             ['patient_procedure_details.status','=',0],
           ])
     ->first();
     ?>
     <option value="{{$procn->id}} "  @if($dataprocn) disabled   @endif>{{$procn->name}}</option>
     @endforeach
    </select>
    </div>


    <div class=" col-md-12">
      <button class="btn btn-sm btn-primary" id="myBtn" type="submit"><strong>Submit</strong></button>
     </div>
</div>
</div>
</div>
  {{ Form::close() }}
    </div>
</div>
</div>



</div>
@endsection
@section('script-reg')
<!-- Page-Level Scripts -->
@endsection
