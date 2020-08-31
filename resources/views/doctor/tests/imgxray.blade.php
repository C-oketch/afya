@extends('layouts.doctor_layout')
@section('title', 'Test')
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
          $fac_setup= $pdetails->set_up;
          $dependantAge = $pdetails->depdob;
          $AfyaUserAge = $pdetails->dob;
          $condition = $pdetails->condition;

if($app_id_prev !==0){ $app_id2 = $app_id_prev;}else{$app_id2 = $app_id;}
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
          $lmp = $pdetails->almp;
          $pregnant = $pdetails->apregnant;
   }

 else {    $dob=$dependantAge;
           $gender=$pdetails->depgender;
           $firstName = $pdetails->dep1name;
           $secondName = $pdetails->dep2name;
           $name =$firstName." ".$secondName;
           $lmp = $pdetails->dlmp;
           $pregnant = $pdetails->dpregnant;
      }


  $interval = date_diff(date_create(), date_create($dob));
  $age= $interval->format(" %Y Year, %M Months, %d Days Old");


}
?>


@include('includes.doc_inc.topnavbar_v2')

 <!--tabs Menus-->
  @include('includes.doc_inc.headmenu')

          <div class="row wrapper border-bottom">
             <div class="float-e-margins">
               <div class="col-lg-12">

<div class="ibox-title">
<h5>X-RAY TESTS</h5>
<div class="ibox-tools">
  <a class="btn btn-primary"  href="{{route('alltestes',$app_id)}}"><i class="fa fa-angle-double-left"></i>&nbsp;BACK</a>
</div>
</div>
<div class="ibox-content">

<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-tests" >
<thead>
<tr>
  <th>#</th>
  <th>Name</th>
  <th>Actions</th>

</tr>
</thead>
<tbody>
<?php
$i=1;?>

@foreach ($cttests as $ctt)
<tr>
    <td>{{$i}}</td>
    <td>{{$ctt->name}}</td>
<?php
$datadetails = DB::table('radiology_test_details')
->Where([['test',$ctt->id],
         ['appointment_id',$app_id],
        ['done',0],
        ['test_cat_id',10],
        ['deleted',0],])
->first();
?>
@if($datadetails)
<td>
  <button class="delete-modal btn btn-danger" data-rtd="{{$datadetails->id}}"
      data-name="{{$ctt->name}}"  data-cat_id="{{$ctt->test_cat_id}}" data-appid="{{$app_id}}">
      <span class="glyphicon glyphicon-minus"></span>Remove
    </button>
</td>
@else
<td>
<button class="add-modal btn btn-primary" data-id="{{$ctt->id}}"
    data-name="{{$ctt->name}}" data-appid="{{$app_id}}" data-catid="{{$ctt->test_cat_id}}">
    <span class="glyphicon glyphicon-plus"></span>ADD
  </button>
</td>
@endif
</tr>
<?php $i++;  ?>
@endforeach
</tbody>

</tbody>
<tfoot>
<tr>

</tr>
</tfoot>
</table>
</div>

</div>
</div>
</div>
</div>

<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"></h4>
</div>
<div class="modal-body">
  {!! Form::open(array('url' => 'xrayTest','method'=>'POST')) !!}

  <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group">
<label>Test Name:</label>
<input type="text" class="form-control" id="name" readonly>
<input type="hidden" class="form-control" id="fid" name="test" >
<input type="hidden" class="form-control" id="appId" name="appointment" >
<input type="hidden" class="form-control" id="catId" name="cat_id" >
</div>
<div class="form-group adds">
<label for="tag_list" class="">Target:</label>
<select class="form-control" name="target" style="width: 100%">
<option value=''>N/A</option>
<option value='Left'>Left</option>
<option value='Right'>Right</option>
<option value='Both'>Both </option>
</select>
</div>
<div class="form-group adds">
<label for="d_list2">Clinical Information:</label>
<textarea rows="4" name="clinical" cols="50" class="form-control"></textarea>
</div>


</div>

<div class="modal-footer">
  <button type="submit" class="btn btn-success btn-sm">
     <span class='glyphicon glyphicon-check'> ADD</span></button>
  <!-- <button type="submit" class="btn btn-primary btn-sm">SUBMIT</button> -->


  <button type="button" class="btn btn-warning" data-dismiss="modal">
<span class='glyphicon glyphicon-remove'></span> Close
</button>
{!! Form::close() !!}
</div>
</div>
</div>
</div>

<div id="myModal2" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"></h4>
</div>
<div class="modal-body">
  {!! Form::open(array('url' => 'xrayTestremove','method'=>'POST')) !!}

  <!-- <form class="form-horizontal" role="form"> -->
  <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group">
<label>Test Name:</label>
<input type="text" class="form-control" id="name2" readonly>
<input type="hidden" class="form-control" id="fid2" name="test" >
<input type="hidden" class="form-control" id="appId2" name="appointment" >
<input type="hidden" class="form-control" id="catId2" name="cat_id" >
</div>



</div>

<div class="modal-footer">

  <button type="submit" class="btn btn-danger btn-sm">
     <span class='glyphicon glyphicon-trash'> DELETE</span></button>


  <button type="button" class="btn btn-warning" data-dismiss="modal">
<span class='glyphicon glyphicon-remove'></span> Close
</button>
{!! Form::close() !!}
</div>
</div>
</div>
</div>
@endsection
@section('script-test')
 <!-- Page-Level Scripts -->
<script src="{{ asset('js/imaging.js') }}"></script>
@endsection
