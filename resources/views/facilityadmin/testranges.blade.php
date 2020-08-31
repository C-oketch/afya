@extends('layouts.facilityadmin2')
@section('title', 'Test Ranges')
@section('content')

<div class="row" id="">
<div class="ibox float-e-margins">
<div class="col-lg-11">
<div class="ibox-title">
<h5>TEST DETAILS</h5>

</div>
<div class="ibox-content">

<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
<tr>
<th>No</th>
<th>Tests</th>
<th>Category</th>
<th>Machine Name</th>
<th>Low Female</th>
<th>High Female</th>
<th>Low Male</th>
<th>High Male</th>
<th>Units</th>
<th>Update</th>
<th>Action</th>

</tr>
</thead>
<tbody>
<?php
$i=1;
$facid = DB::table('facility_admin')
->where('user_id', '=', Auth::user()->id)->first();

?>
@foreach ($testranges as $fact)
<?php  $testnew=DB::table('test_ranges')
->where([['facility_id', '=', $facid->facilitycode],
['tests_id', '=',$fact->testId],])
->first();
?>
<tr class="item{{$fact->testId}}">
<td>{{$i}}</td>
<td>{{$fact->tname}}</td>
<td>{{$fact->subname}}</td>
<td>{{$fact->machine}}</td>
<td>{{$fact->low_female}}</td>
<td>{{$fact->high_female}}</td>
<td>{{$fact->low_male}}</td>
<td>{{$fact->high_male}}</td>
<td>{{$fact->units}}</td>
@if($testnew)
<td>
<button class='edit-modal btn btn-info' data-id="{{$fact->id}}" data-scat="{{$fact->subname}}" data-tname="{{$fact->tname}}" data-scat="{{$fact->subname}}"
data-mid="{{$fact->machine_id}}" data-mnm="{{$fact->machine}}" data-hf="{{$fact->high_female}}" data-hm="{{$fact->high_male}}" data-lf="{{$fact->low_female}}"
data-lm="{{$fact->low_male}}" data-unit="{{$fact->units}}" data-facid="{{$facid->facilitycode}}">
<span class='glyphicon glyphicon-edit'></span> EDIT</button>
</td>
<td>{!! Form::open(['method' => 'DELETE','route' => ['ranges.destroy', $fact->id],'style'=>'display:inline']) !!}
{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
{!! Form::close() !!}
</td>
@else
<td> </td>

<td><button class="add-modal btn btn-primary" data-id="{{$fact->testId}}" data-tname="{{$fact->tname}}"
data-scat="{{$fact->subname}}" data-facid="{{$facid->facilitycode}}" >
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

                    <div id="myModal" class="modal fade" role="dialog">
                           <div class="modal-dialog">
                             <!-- Modal content-->
                             <div class="modal-content">
                               <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                                 <h4 class="modal-title"></h4>
                               </div>
                               <div class="modal-body">
                              <div class="form-group">




<form class="form-horizontal" role="form">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
<label class="control-label col-sm-4" for="availability">Test Category:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="scat" readonly>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="availability">Test Name:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="n" readonly>
<input type="hidden" class="form-control" id="fid" name="test_id" >
<input type="hidden" class="form-control" id="facility" name="facility_id" >

</div>
</div>
<div class="col-md-12">
<div class="col-lg-6 b-r">
  <div class="col-lg-11 ">
<div class="form-group">
<label>Units:</label>
<input type="text" id="unit" name="units" class="form-control">
</div>
<div class="form-group">
<label>Low Female:</label>
<input type="text" id="lf" name="low_female" class="form-control">
</div>
<div class="form-group">
<label>High Female:</label>
<input type="text" id="hf" name="high_female" class="form-control">
</div>
</div>
</div>

<div class="col-lg-5 col-lg-offset-1">
<div class="form-group">
<label>Low Male:</label>
<input type="text" id="lm" name="low_male" class="form-control">
</div>
<div class="form-group">
<label>High Male:</label>
<input type="text" id="hm" name="high_male" class="form-control">
</div>
<div class="form-group">
<label for="tag_list" class="">Machine:</label>
<select class="form-control" name="machine_name" id="machineId" style="width: 100%" required>
<?php $testm=DB::table('test_machines')
->distinct()->get(['id','name']); ?>

<option value=''>choose one</option>
@foreach($testm as $tstms)
<option value='{{$tstms->id}}'>{{$tstms->name}}{{$tstms->id}}</option>
@endforeach
</select>
</div>


</div>
</div>

</div>

<div class="modal-footer">
  <button type="button" class="btn actionBtn" data-dismiss="modal">
    <span id="footer_action_button" class='glyphicon'> </span>
  </button><button type="button" class="btn btn-warning" data-dismiss="modal">
<span class='glyphicon glyphicon-remove'></span> Close
</button>
</div>
{!! Form::close() !!}
                               </div>
                             </div>
                           </div>
                          </div>
                        </div>



@endsection
@section('script')
 <!-- Page-Level Scripts -->
<script src="{{ asset('js/ranges.js') }}"></script>
@endsection
