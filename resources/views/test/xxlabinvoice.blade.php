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

if($pdetails){
	$dependantId = $pdetails->persontreated;
	$afyauserId = $pdetails->afya_user_id;
	$appid = $pdetails->id;
  $ptid=$pdetails->ptid;
  $docname=$pdetails->docname;
  $facility_from=$pdetails->FacilityName;
  $ptd_id=$pdetails->ptd_id;

}elseif($alternative){
	$dependantId = $alternative->persontreated;
	$afyauserId = $alternative->afya_user_id;
  $ptid=$alternative->ptid;
  $docname=$alternative->docname;
  $facility_from=$alternative->FacilityName;
  $ptd_id=$alternative->ptd_id;
  $appid = '';
}


	 $afyadetails = DB::table('afya_users')
   ->leftJoin('constituency', 'afya_users.constituency', '=', 'constituency.id')
   ->select('afya_users.*','constituency.Constituency')
	 ->where('afya_users.id', '=',$afyauserId)
	 ->first();

	 $dob=$afyadetails->dob;
	 $gender=$afyadetails->gender;
	 $firstName = $afyadetails->firstname;
	 $secondName = $afyadetails->secondName;
	 $name =$firstName." ".$secondName;
   $msisdn=$afyadetails->msisdn;
   $nhif=$afyadetails->nhif;
   $idno=$afyadetails->nationalId;
   $constituency=$afyadetails->Constituency;
   $interval = date_diff(date_create(), date_create($dob));
   $age= $interval->format(" %Y Year, %M Months, %d Days Old");

if ($dependantId !='Self'){
	$deppdetails = DB::table('dependant')
	->select('dependant.*')
	->where('id', '=',$dependantId)
	->first();

	          $dob=$deppdetails->dob;
            $genderd=$deppdetails->gender;
            $firstName = $deppdetails->firstName;
            $secondName = $deppdetails->secondName;
            $named =$firstName." ".$secondName;
            $interval = date_diff(date_create(), date_create($dob));
            $aged= $interval->format(" %Y Year, %M Months, %d Days Old");

}




?>
<input name="b_print" type="button" class="btn btn-sm btn-primary ipt"   onClick="printdiv('div_print');" value=" Print ">
<a href="{{url('test')}}" class="btn btn-primary btn-sm pull-right">  <i class="fa fa-arrow-left"></i>Go Back</a>

<div id="div_print">
<div class="row wrapper border-bottom white-bg page-heading">
<div class="content-page  equal-height">
		<div class="content">
				<div class="container">


      <div class="row">
          <div class="col-md-10">
            <div class="invoice-title">
        			<h2>Invoice</h2><h3 class="pull-right">Invoice #{{$facilityId}}0{{$month}}0{{$year}}{{$ptd_id}}</h3>
        		</div>
        		<hr>
    			<div class="col-md-6">
    				<address>
            <strong>Billed To:</strong><br>
    				 Name : {{$name}}<br>
    				 Phone : {{$msisdn}}<br>
             Constituency: {{$constituency}}

    				</address>

    			</div>
    			<div class="col-md-6 text-right">
    				<address>
              <strong>Requested By:</strong><br>
        			Doctor : {{$docname}}<br>
    					Facility : {{$facility_from}}<br>

    				</address>

    			</div>
    		</div>
        </div>

        <div class="row">
          <div class="col-md-10">
    			<div class="col-md-6">
            @if($dependantId =='Self')
    				<address>
    					<strong>Patient:</strong><br>
              Name : {{$name}}<br>
     					Gender : @if($gender==1){{"Male"}}@else{{"Female"}}@endif<br>
     					Age : {{$age}}<br>
              NHIF : {{$nhif}}<br>
              ID No : {{$idno}}<br>
             </address>
             @else
             <address>
     					<strong>Patient:</strong><br>
               {{$named}}<br>
      					@if($genderd==1){{"Male"}}@else{{"Female"}}@endif<br>
      					{{$aged}}<br>
              </address>
              @endif
    			</div>
    			<div class="col-md-6 text-right">
    				<address>
    					<strong>Done By:</strong><br>
    					{{$facility}}<br>
              {{$ward}}<br>
              {{$county}}<br>
              <!-- <strong>Date Recieved:</strong><br>
    					March 7, 2014<br><br> -->
    				</address>
    			</div>
    		</div>
    	</div>



    <div class="row">
    	<div class="col-md-10">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td class="text-center"><strong>Test Category</strong></td>
        							<td class="text-center"><strong>Test Name</strong></td>
        							<td class="text-right"><strong>Amount (KSH)</strong></td>
                      <td class="text-right"><strong>Action</strong></td>
                      </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
                  @foreach($tsts as $tst)
                  <?php
                  $payments = DB::table('payments')->select('amount')
                  ->where([  ['patient_test_id', '=',$ptid],['lab_id', '=',$tst->testId], ])
                  ->first();

                  ?>

                  <tr class="item{{$tst->testId}}">
                  <td class="thick-line text-center">{{$tst->tsname}}</td>
                  <td class="thick-line text-center">@if($tst->testmore){{$tst->testmore}}@else{{$tst->tname}}@endif</td>
                @if($payments)<td class="thick-line text-center">{{$payments->amount}}</td>@else
                <td class="thick-line text-center">{{$tst->amount}}</td>@endif

                  @if($payments)
                  <td class="thick-line text-right"><button class="btn btn-info"><span class="glyphicon glyphicon-plus"></span>PAID</button>
                  </td>
                   @else
                  <td class="thick-line text-right">

                  <form class="form-horizontal" role="form" method="POST" action="/labinvoicepay">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" class="form-control" id="fid" name="testId" value="{{$tst->testId}}" >
                  <input type="hidden" class="form-control" id="ptid" name="ptid" value="{{$ptid}}">
                  <button type="submit" class="btn btn-primary btn-sm">PAY</button>
                    {!! Form::close() !!}
                  </td>
                  @endif
                  </tr>
                  @endforeach
    							<!-- <tr>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Total</strong></td>
    								<td class="no-line text-center">{{$cost->total_cost}}</td>
    							</tr> -->
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
				</div><!--content-->
		</div><!--content page-->

@endsection
@section('script')

@endsection
