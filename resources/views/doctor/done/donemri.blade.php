@extends('layouts.doctor_layout')
@section('title', 'Mri Tests')
@section('content')
<?php
 $dependantId = $tsts1->persontreated;
	$afyauserId = $tsts1->afya_user_id;
	$appId = $tsts1->appointment_id;
	$ptdId = $tsts1->id;
	$facility = $tsts1->FacilityName;



	            if ($dependantId =='Self')   {
	           	 $afyadetails = DB::table('afya_users')
	           ->select('dob','gender','firstname','secondName')
	           	->where('id', '=',$afyauserId)->first();

	           	 $dob=$afyadetails->dob;
	           	 $gender=$afyadetails->gender;
	           	 $firstName = $afyadetails->firstname;
	           	 $secondName = $afyadetails->secondName;
	           	 $name =$firstName." ".$secondName;
	           }else{
	           	$deppdetails = DB::table('dependant')
	             ->select('dob','gender','firstName','secondName')
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
<?php
$frepo = DB::table('mri_findings')
->leftJoin('radiology_test_result', 'mri_findings.id', '=', 'radiology_test_result.findings_id')
->where('mri_findings.mri_tests_id', '=',$tsts1->mriid)
->select('radiology_test_result.created_at')
->first();
	?>
<p>
<a class="btn btn-success btn-lg " href="{{route('tstdetails',$tsts1->ptid)}}"><i class="fa fa-arrow-left"></i>GO BACK</a>
<button name="b_print" class="btn btn-info btn-lg ipt" type="button" onClick="printdiv('div_print');"> <i class="fa fa-paste"></i>PRINT</button>
</p>
<div id="div_print">
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="row">

      <div class="col-md-10 col-md-offset-1 white-bg">
  <br /><br />
      <div class="col-md-6">
        <address>

        <strong>Patient:</strong><br>
        Name: {{$name}}<br>
        Gender: {{$gender}}<br>
        Age: {{$age}}
      </address>

      </div>
      <div class="col-md-6 text-right">
        <address>
          <strong>Requested By:</strong><br>
           {{$tsts1->docname}}<br>
          <strong>Facility :</strong><br>
          {{$tsts1->FacilityName}}<br>


        </address>
      </div>
    </div>
  </div>
    <div class="row">
  <div class="col-md-10">
  			<h3 class="text-center">{{$tsts1->category}} REPORT</h3>
        </div>
  </div>
<div class="row wrapper border-bottom page-heading">
  <div class="content-page  equal-height">
		<div class="content">

             <div class="col-lg-11 col-md-offset-1">
		                    <div class="ibox float-e-margins">
		                        <div class="ibox-title">
		                            <h5>TEST : {{$tsts1->tstname}} @if($tsts1->target)-{{$tsts1->target}} @else @endif</h5>

		                        </div>
		                        <div class="ibox-content">
		                            <form class="form-horizontal">
																	<div class="form-group">
																		<p><b>Clinical Information</b></p><p>{{$tsts1->clinicalinfo}}</p>
																		 <p><b>TECHNIQUE</b></p><p>{{$tsts1->technique}}</p>

		                            </form>
		                        </div>
		                    </div>
		                </div>



<div class="col-lg-12">
		<div class="ibox float-e-margins">
				<div class="ibox-title">
						<h5>Findings </h5>
				</div>

				<div class="ibox-content">
						<div class="row">
									<form role="form">
											<?php
											$freport = DB::table('mri_findings')
											->leftJoin('radiology_test_result', 'mri_findings.id', '=', 'radiology_test_result.findings_id')
											->where([['mri_findings.mri_tests_id', '=',$tsts1->mriid],['radiology_test_result.radiology_td_id', '=',$tsts1->rtdid]])
											->select('radiology_test_result.results','mri_findings.findings')
											->get();
												?>
											@foreach($freport as $frpt)
                 <div class="form-group"><label>{{$frpt->findings}} :</label>{{$frpt->results}}</div>
                    @endforeach
										</form>
								</div>
				</div>
		</div>
</div>
<div class="col-lg-12">
		<div class="ibox float-e-margins">
				<div class="ibox-title">
						<h5>IMPRESSION</h5>
				</div>
				<div class="ibox-content">

						<p>{{$tsts1->target}} {{$tsts1->tstname}}</p>
            <br /><br />
            <strong>Done By</strong><br />
            <p>DR. {{$rdlgist->firstname}}  {{$rdlgist->secondname}}</p>
            <p>FACILITY : {{$rdlgist->FacilityName}}</p>
             <strong>Radiologist</strong>
        </div>
		</div>
  </div>
</div>
</div><!--content-->

  </div><!--content page-->
</div><!--content page-->
</div><!--content page-->
</div><!--printpage-->
@endsection
