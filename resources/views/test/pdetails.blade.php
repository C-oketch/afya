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

if($pdetails)
{
	$dependantId = $pdetails->persontreated;
	$afyauserId = $pdetails->afya_user_id;
	$appid = $pdetails->id;
  $docname=$pdetails->docname;
  $facility_from=$pdetails->FacilityName;
  $ptid_p=$pdetails->ptid;
}
elseif($alternative)
{
	$dependantId = $alternative->dependant_id;
	$afyauserId = $alternative->afya_user_id;
  $docname=$alternative->docname;
  $facility_from=$alternative->FacilityName;
  $ptid_a=$alternative->ptid;

}

if ($dependantId =='Self'){
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
<div class="row wrapper border-bottom white-bg page-heading">


  <div class="row">
      <div class="col-md-12">
        <div class="invoice-title">
          <!-- <h2>Invoice</h2><h3 class="pull-right">Invoice #</h3> -->
        </div>
        <!-- <hr> -->
        <br /><br />
      <div class="col-md-6">
        <address>
        <strong>Patient:</strong><br>
         Name: {{$name}}<br>
         Gender: @if($gender==1){{"Male"}}@else{{"Female"}}@endif<br>
         Age: {{$age}}
        </address>

      </div>
      <div class="col-md-6 text-right">
        <address>
          <strong>Requested By:</strong><br>
          Name : {{$docname}}<br>
          Facility : {{$facility_from}}<br>
          <strong>LAB :</strong><br>
           {{$facility}}
        </address>

      </div>
    </div>
    </div>



  <div class="ibox float-e-margins">
     <div class="col-lg-12">
       <div class="tabs-container">
           <div class="wrapper wrapper-content animated fadeInRight">

<div class="row">

												<div class="col-md-12">
												<div class="ibox float-e-margins">
														<div class="ibox-title">
                            <h5>Tests Requested</h5>
																<div class="ibox-tools">
                                  <!-- <a class="btn btn-primary btn-xs txtwht" href="#">End Visit</a> -->

																</div>
														</div>
														<div class="ibox-content" id="shttable">
                              <div class="table-responsive">
														<table class="table table-striped table-bordered table-hover dataTables-example" >
														<thead>
																										<tr>
																												<th>No</th>
																												<th>Test Name</th>
																												<th>Category</th>
																												<th>Sub- Category</th>
																												<th>Date Created</th>
																												<th>Specimen No</th>
                                                        <th>Action</th>
                                                        <th>Transfer</th>

                                                      </tr>
																								</thead>
                                              <tbody>
																								<?php $i =1;?>
																								@foreach($tsts as $tst)

																							<?php
                                              if($pdetails)
                                              {
                                                $payment = DB::table('payments')
                                                ->select('amount','status')
                                                ->where([
                                                  ['lab_id', '=',$tst->tests_reccommended],
                                                  ['patient_test_id', '=',$ptid_p],
                                                ])
                                                ->first();
                                              }elseif($alternative) {
                                                $payment = DB::table('payments')
                                                ->select('amount','status')
                                                ->where([
                                                  ['lab_id', '=',$tst->tests_reccommended],
                                                  ['patient_test_id', '=',$ptid_a],
                                                ])
                                                ->first();

                                              }

                                                    ?>
																									<tr>
																									<td>{{$i}}</td>
																								  <td>@if($tst->testmore){{$tst->testmore}}@else{{$tst->tname}}@endif</td>
                                                   <td>{{$tst->tcname}}</td>
																									<td>{{$tst->tsname}}</td>
                                                  <td>{{$tst->date}}</td>
                                                  <td>{{$facilityId}}{{$tst->patTdid}}</td>
                                                      @if($tst->done ==0)
                                                  <td>
                                                    @if($tst->transfer == 'N')

                                                  @if($payment)
                                                  <a class="btn btn-primary btn-xs txtwht" href="{{route('perftest',$tst->patTdid)}}">Perform Test</a>
                                                @else <a class="btn btn-danger">Pending Payment </a> @endif

                                                     @else <a class="btn btn-danger"></a>
                                                     @endif
                                                  </td>
                                                <td>
                                                @if($payment)
                                                  @if($tst->transfer == 'N')
                                                  <a class="btn btn-success btn-xs txtwht" href="{{route('testtransfer',$tst->patTdid)}}">Transfer Test</a>
                                                  @else <a class="btn btn-danger">Transfered</a>
                                                  @endif
                                                @endif
                                                  </td>
                                                  @else
                                                  <td><a class="btn btn-info">Done</a>
                                                  </td>
                                                  @endif
                                                 </tr>
																								<?php $i++; ?>
																									@endforeach

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
