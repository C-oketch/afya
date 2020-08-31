@extends('layouts.test')
@section('title', 'Tests')
@section('content')
<?php
$afya_user_id=$ultra->afya_user_id;
  $dependant_id=$ultra->dependant_id;
  $ptid=$ultra->ptid;


if ($ultra->dependant_id =='Self') {
  $name= $ultra->firstname.''.$ultra->secondName;
  $gender=$ultra->gender;
  $dob=$ultra->dob;

}else{
  $name= $ultra->depname1.''.$ultra->depname2;
  $gender=$ultra->depgender;
  $dob=$ultra->depdob;

}
?>
<div class="row white-bg">
    <div class="col-md-8  col-md-offset-2">
<div class="col-md-6">
      <address>
      <strong>Patient:</strong><br>
      Name : {{$name}}<br>
      Gender: @if($gender==1){{"Male"}}@else{{"Female"}}@endif<br>
      <?php $interval = date_diff(date_create(), date_create($dob));
           $aged= $interval->format(" %Y Year, %M Months, %d Days Old");
      ?>
      Age: {{$aged}}
    </address>
</div>
<div class="col-md-6 text-center">
      <address>
  </address>
</div>
</div>
</div>

@section('left-menu')
<li class="active">
<a href="{{URL('test.pinfo',$afya_user_id)}}"><i class="fa fa-th-large"></i> <span class="nav-label">ADD TESTS</span> <span class="fa arrow"></span></a>
</li>
@endsection

<div class="row" id="">
<div class="ibox float-e-margins">
<div class="col-md-12">
<div class="ibox-title">
<h5>ULTRASOUND TESTS</h5>

</div>
<div class="ibox-content">

<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example" >
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
<?php  $cttests = DB::table('ultrasound')->get();  ?>
@foreach ($cttests as $ctt)

  <tr class="item{{$ctt->id}}">
    <td> {{$ctt->id}}</td>
    <td>{{$ctt->name}}</td>


<?php
$datadetails = DB::table('radiology_test_details')
->Where([['test',$ctt->id],
         ['patient_test_id',$ptid],
        ['done',0],
        ['test_cat_id',12],])
->first();
?>
@if($datadetails)
<td><button class="btn btn-info" >
<span class="glyphicon glyphicon-plus"></span>ADDED
</button>
</td>
@else
<td>
<button class="add-modal btn btn-primary" data-id="{{$ctt->id}}" data-dep="{{$dependant_id}}" data-afya="{{$afya_user_id}}"
    data-name="{{$ctt->name}}" data-ptid="{{$ptid}}" data-catid="{{$ctt->test_cat_id}}">
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
  <form class="form-horizontal" role="form">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group">
<label class="control-label col-sm-4" for="availability">Test Name:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="name" readonly>
<input type="text" class="form-control" id="fid" name="test" >
<input type="text" class="form-control" id="ptid" name="patient_test_id" >
<input type="text" class="form-control" id="catId" name="cat_id" >
<input type="text" class="form-control" id="dep" name="dependant_id" >
<input type="text" class="form-control" id="afya" name="afya_user_id" >
</div>
</div>
<div class="form-group">
<label for="tag_list" class="">Target:</label>
<select class="form-control" name="target" style="width: 100%">
<option value=''>N/A</option>
<option value='Left'>Left</option>
<option value='Right'>Right</option>
<option value='Both'>Both </option>
</select>
</div>
<div class="form-group ">
<label for="d_list2">Clinical Information:</label>
<textarea rows="4" name="clinical" cols="50" class="form-control"></textarea>
</div>


</div>

<div class="modal-footer">
  <button type="button" class="btn actionBtn" data-dismiss="modal">
    <span id="footer_action_button" class='glyphicon'> </span>
  </button>
  <!-- <button type="submit" class="btn btn-primary btn-sm">SUBMIT</button> -->


  <button type="button" class="btn btn-warning" data-dismiss="modal">
<span class='glyphicon glyphicon-remove'></span> Close
</button>
{!! Form::close() !!}
</div>
</div>
</div>
</div>

@endsection
@section('script')
 <!-- Page-Level Scripts -->
<script src="{{ asset('js/radiology.js') }}"></script>
@endsection
