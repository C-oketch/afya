@extends('layouts.test')
@section('title', 'Tests')
@section('content')
<?php
$test = (new \App\Http\Controllers\TestController);
$testdet = $test->TDetails();
foreach($testdet as $DataTests){
$facility = $DataTests->FacilityName;
$firstname = $DataTests->firstname;
$secondName = $DataTests->secondname;
$facilityId = $DataTests->FacilityCode;
$TName = $firstname.' '.$secondName;


}
if($pdetails){
  $dependantId = $pdetails->persontreated;
	$afyauserId = $pdetails->afya_user_id;
	$ptid = $pdetails->ptid;
	$docname=$pdetails->docname;

}elseif($alternative){

	$dependantId = $alternative->persontreated;
	$afyauserId = $alternative->afya_user_id;
	$ptid = $alternative->ptid;
	$docname=$alternative->docname;
}

 if ($dependantId =='Self')   {
	 $afyadetails = DB::table('afya_users')
	 ->select('afya_users.*')
	 ->where('id', '=',$afyauserId)
	 ->first();

	 $dob=$afyadetails->dob;
	 $gender=$afyadetails->gender;
	 $firstName = $afyadetails->firstname;
	 $secondName = $afyadetails->secondName;
	 $name =$firstName." ".$secondName;
}else{
	$deppdetails = DB::table('dependant')
	->select('dependant.*')
	->where('id', '=',$dependantId)
	->first();

	          $dob=$deppdetails->dob;
            $gender=$deppdetails->gender;
            $firstName = $deppdetails->firstName;
            $secondName = $deppdetails->secondName;
            $name =$firstName." ".$secondName;
}
$interval = date_diff(date_create(), date_create($dob));
$age= $interval->format(" %Y Year, %M Months, %d Days Old");

?>
<input name="b_print" type="button" class="btn btn-sm btn-primary ipt"   onClick="printdiv('div_print');" value=" Print ">
<div id="div_print">
<div class="row wrapper border-bottom white-bg page-heading">
<div class="content-page  equal-height">
		<div class="content">
				<div class="container">

					<div class="row">
							<div class="col-md-10 col-md-offset-1">

							<div class="col-md-6">
								<address>
								<strong>Patient:</strong><br>
								Name: {{$name}}<br>
								Gender: @if($gender==1){{"Male"}}@else{{"Female"}}@endif<br>
								Age: {{$age}}
				      </address>

							</div>
							<div class="col-md-6 text-center">
								<address>
									<strong>Requested By:</strong><br>
									Doctor: {{$docname}}<br>
									LAB: {{$facility}}<br>


								</address>
							</div>
						</div>
				</div>




				<div class="row">
				                <div class="col-lg-8 col-md-offset-1">
				                <div class="ibox float-e-margins">

				                    <div class="ibox-content">
                                  <table class="table">
				                            <thead>
				                            <tr>
				                                <th>#</th>
				                                <th>Test Category</th>
				                                <th>Test Name</th>
				                                <th>Amount (KSH)</th>
																				<th>Paid</th>
				                            </tr>
				                            </thead>
				                            <tbody>
																			<?php $i =1; ?>

																			@foreach($tsts as $tst)

																			<?php
																			if ($tst->test_cat_id== '9') {
																				$ct=DB::table('ct_scan')
																				->leftJoin('test_prices_ct_scan', 'ct_scan.id', '=', 'test_prices_ct_scan.ct_scan_id')
																				->select('ct_scan.*','test_prices_ct_scan.amount')
																				->where('ct_scan.id', '=',$tst->test) ->first();
																				$test = $ct->name;
																				$amount =$ct->amount;

																			} elseif ($tst->test_cat_id== 10) {
																				$xray=DB::table('xray')
																				->leftJoin('test_prices_xray', 'xray.id', '=', 'test_prices_xray.xray_id')
																				->select('xray.*','test_prices_xray.amount')
																				->where('xray.id', '=',$tst->test) ->first();
																				$test = $xray->name;
																				$amount =$xray->amount;
																			} elseif ($tst->test_cat_id== 11) {
																				$mri=DB::table('mri_tests')
																				->leftJoin('test_prices_mri', 'mri_tests.id', '=', 'test_prices_mri.mri_id')
																				->select('mri_tests.*','test_prices_mri.amount')
																				->where('mri_tests.id', '=',$tst->test) ->first();
																				$test = $mri->name;
																				$amount =$mri->amount;
																			}elseif ($tst->test_cat_id== 12) {
																				$ultra=DB::table('ultrasound')
																				->leftJoin('test_prices_ultrasound', 'ultrasound.id', '=', 'test_prices_ultrasound.ultrasound_id')
																				->select('ultrasound.*','test_prices_ultrasound.amount')
																				->where('ultrasound.id', '=',$tst->test) ->first();
																				$test = $ultra->name;
																				$amount =$ultra->amount;
                                      }elseif ($tst->test_cat_id== 13) {
                                        $ultra=DB::table('ultrasound')
                                        ->leftJoin('test_prices_ultrasound', 'ultrasound.id', '=', 'test_prices_ultrasound.ultrasound_id')
                                        ->select('ultrasound.*')
                                        ->where('ultrasound.id', '=',$tst->test) ->first();
                                        $test = $ultra->name;
                                        $amount =50;
                                      }
										$payments = DB::table('payments')
										->where([  ['patient_test_id', '=',$ptid],
										           ['imaging_id', '=',$tst->patTdid],
										         ])
										->first();
																			?>
																				<tr class="item{{$tst->patTdid}}">
																				<td>{{$i}}</td>
																				<td>{{$tst->tcname}}</td>
																				<td>{{$test}}</td>
																				<td>{{$amount}}</td>
																				<!-- <td>{{$tst->patTdid}}</td> -->
																				@if($payments)
																				<td><button class="btn btn-info"><span class="glyphicon glyphicon-plus"></span>PAID</button>
																				</td>
																				@else
																				<td>    <button class="add-modal btn btn-primary" data-id="{{$tst->patTdid}}"
																				data-amount="{{$amount}}"  data-ptid="{{$ptid}}">
																				<span class="glyphicon glyphicon-plus"></span>PAY
																				</button>
																				</td>
																				@endif
																			 </tr>
																			<?php $i++; ?>
																				@endforeach
																				<!-- <tr><td></td>
																				<td></td>
																				<td>TOTAL</td>
																				<td> 789</td>
																				</tr> -->

																			 </tbody>
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
											<form class="form-horizontal" role="form" method="POST" action="/radypayment" novalidate>
										 <input type="hidden" name="_token" value="{{ csrf_token() }}">

				                <div class="form-group">
				                  <!-- <label class="control-label col-sm-2" for="id">ID:</label> -->


				                <div class="form-group">
				                  <div class="col-sm-10">
				                    <input type="hidden" class="form-control" id="fid" name="testId" >
				                    <!-- <input type="hidden" class="form-control" id="app" name="appId" > -->
                             <input type="hidden" class="form-control" id="ptid" name="ptid" >
				                  </div>
				                </div>
				                 <div class="form-group">
				                  <label class="control-label col-sm-2" for="availability">Amount(ksh):</label>
				                  <div class="col-sm-10">
				                    <input type="text" class="form-control" id="amount" name="amount" readonly>
				                    </div>
				                </div>

				               <div class="form-group">
				                <label class="control-label col-sm-2" for="availability">Payment Method:</label>

				                  <div class="col-sm-10">
				                    <label class="checkbox-inline">
				                       <input type="radio"  value="Cash" name="paym" id="stat2"> Cash
				                       <input type="radio"  value="Mpesa" name="paym" id="stat1"> Mpesa
				                       <input type="radio"  value="Insurance" name="paym" id="stat1">Insurance

				                  </label></div>
				              </div>


				              <div class="modal-footer">

                    <button type="submit" class="btn btn-primary btn-sm">SUBMIT</button>

				                <button type="button" class="btn btn-warning" data-dismiss="modal">
				                  <span class='glyphicon glyphicon-remove'></span> Close
				                </button>

				              </div>
											{!! Form::close() !!}
				            </div>
				          </div>
				        </div>
				       </div>
				     </div>


      </div>
		</div>

      </div>
		</div>
		</div><!--content page-->

		</script>
@endsection
@section('script')
 <!-- Page-Level Scripts -->
<script src="{{ asset('js/radypayment.js') }}"></script>
@endsection
