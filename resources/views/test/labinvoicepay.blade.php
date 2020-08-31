 @extends('layouts.test')
@section('title', 'Tests')
@section('content')
<?php
use Carbon\Carbon;
$test = (new \App\Http\Controllers\TestController);
$testdet = $test->TDetails();
foreach($testdet as $DataTests){
$facility = $DataTests->FacilityName;
$firstname = $DataTests->firstname;
$secondName = $DataTests->secondname;
$facilityId = $DataTests->FacilityCode;
$TName = $firstname.' '.$secondName;
$ward= $DataTests->Ward;
$county = $DataTests->County;




$now = Carbon::now();
$year=$now->year;
$month=$now->month;



}
?>

<div class="wrapper wrapper-content animated fadeInRight">

  <div class="row">
            <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{$tsts->name}} Test</h5>
                        <div class="ibox-tools">
                          <a href="{{route('labinvoice',$ptid)}}" class="btn btn-primary ">  <i class="fa fa-exchange"></i>Go Back</a>
                        </div>
                    </div>
<div class="ibox-content">
    <div class="row">
        <form class="form-horizontal" role="form" method="POST" action="/paymentt">
             <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group"><label class="col-lg-2 control-label">Cost</label>
              <div class="col-lg-10"><input type="text" class="form-control" id="cost" name="cost" value="{{$tsts->amount}}">
                <!-- <span class="help-block m-b-none">Example block-level help text here.</span> -->
              </div>
            </div>
            <div class="form-group"><label class="col-lg-2 control-label">Availability</label>
              <div class="col-lg-10"><input type="text" class="form-control" id="availability" name="availability" value="{{$tsts->availability}}">
              </div>
            </div>

        <div class="form-group">
        <div class="col-sm-10">
        <input type="hidden" class="form-control" id="testId" name="testId" value="{{$tsts->testId}}" >
        <input type="hidden" class="form-control" id="ptid" name="ptid" value="{{$ptid}}">
        </div>
        </div>

    <div class="form-group"><label class="col-lg-2 control-label">Discount:</label>
    <div class="col-sm-10">	<select class="form-control rounded" name="discount" id="discount">
    <option value="0" >None</option>
    @foreach($discount as $item)
    <option value="{{$item->amount}}" >{{$item->reason}} - (ksh : {{$item->amount}})</option>
    @endforeach
    </select>
    </div>
    </div>

 <div class="form-group"><label class="col-lg-2 control-label">Payment Method:</label>
<div class="col-sm-10">
<label class="checkbox-inline">
 <input type="radio"  value="Cash" name="paym" id="stat2"> Cash
 <input type="radio"  value="Mpesa" name="paym" id="stat1"> Mpesa
 <input type="radio"  value="Insurance" name="paym" id="stat1">Insurance
 <input type="radio"  value="Invoice" name="paym" id="stat1">Invoice
</label>
</div>
</div>
<div class="form-group"><label class="col-lg-2 control-label">Amount</label>
  <div class="col-lg-10"><input type="text" class="form-control" id="amount" name="amount" readonly>
  </div>
</div>

<div>
    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Submit</strong></button>
</div>
	{!! Form::close() !!}


                        </div>
                    </div>
                </div>
            </div>

  </div>
 </div>

@endsection
@section('script')

<script>
var mycost= $('#cost')
$('#amount').val(mycost.val());

$('#discount,#cost').change(function(){
  var discount = parseFloat($('#discount').val()) || 0;
  var mycost= $('#cost').val();

  $('#amount').val(mycost - discount);
});</script>

@endsection
