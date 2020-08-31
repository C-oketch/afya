@extends('layouts.doctor_layout')
@section('title', 'Test')

@section('styles')

@endsection
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

<!--tabs Menus-->
  @include('includes.doc_inc.headmenu')

  <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All Laboratory Tests</h5>
                        <div class="ibox-tools">
                          <a class="btn btn-primary"  href="{{route('alltestes',$app_id)}}"><i class="fa fa-angle-double-left"></i>&nbsp;BACK</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">

  <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover dataTables-tests" >
  <thead>
  <tr>
  <th>No</th>
  <th>Tests</th>
  <th>Sub Category</th>
  <th>Category</th>
  <th>Action</th>
  </tr>
  </thead>
  <tbody>
  <?php
  $i=1;?>
  @foreach ($tests as $tsts)
  <tr class="item{{$tsts->testId}}">
  <td>{{$tsts->testId}}</td>
  <td>{{$tsts->tname}}</td>
  <td>{{$tsts->subname}}</td>
  <td>{{$tsts->cname}}</td>
  <?php
  $datadetails = DB::table('patient_test_details')
  ->Where([['tests_reccommended',$tsts->testId],
  ['appointment_id',$app_id],
  ['deleted',0],
  ['done',0],])
  ->first();
  ?>
  @if($datadetails)
  <td>
  <a class="btn btn-danger"  href="{{route('testlab.remov',$datadetails->id)}}"><i class="glyphicon glyphicon-minus"></i>&nbsp;REMOVE</a>
  </td>
  @else
  <td><button class="add-modal btn btn-primary" data-id="{{$tsts->testId}}" data-tname="{{$tsts->tname}}"
  data-scat="{{$tsts->subname}}" data-cat="{{$tsts->cname}}" data-appid="{{$app_id}}">
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
</div><!-- emargis" -->
</div><!-- row" -->


<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"></h4>
</div>
<div class="modal-body">
<form class="form-horizontal" role="form" action="/testsave" method="POST">

<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
<label class="control-label col-sm-4" for="availability">Test Category:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="cat" readonly>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="availability">Test Subcategory:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="scat" readonly>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="availability">Test Name:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="n" readonly>
<input type="hidden" class="form-control" id="fid" name="test_id" >
<input type="hidden" class="form-control" id="appId" name="appointment_id" >

</div>
</div>
<div class="form-group ">
<label for="d_list2">Doctor Note(For test):</label>
<textarea rows="4" name="docnote" id="docnote" cols="50" class="form-control"></textarea>
</div>


</div>

<div class="modal-footer">
<!-- <button type="button" class="btn actionBtn" data-dismiss="modal">
<span id="footer_action_button" class='glyphicon'> </span>
</button> -->
<button type="submit" class="btn btn-primary btn-sm">SUBMIT</button>


<button type="button" class="btn btn-warning" data-dismiss="modal">
<span class='glyphicon glyphicon-remove'></span> Close
</button>
{!! Form::close() !!}
</div>
</div>
</div>



</div>
<!-- Modal ends -->

@endsection
@section('script-test')
<!-- Page-Level Scripts -->
<script src="{{ asset('js/tests.js') }}"></script>

@endsection
