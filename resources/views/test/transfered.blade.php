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

        </address>

      </div>
      <div class="col-md-6 text-right">
        <address>

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
                            <h5>Tests Transfered</h5>
																<div class="ibox-tools">
                                    <a class="collapse-link">
																			<!-- <button type="button" id="tshow" class="btn btn-primary btn-sm">Add Test</button> -->
                                     </a>
																		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
																				<i class="fa fa-wrench"></i>
																		</a>
																		<ul class="dropdown-menu dropdown-user">

																				<li><a href="#">Config option 1</a>
																				</li>
																				<li><a href="#">Config option 2</a>
																				</li>
																		</ul>
																		<a class="close-link">
																				<i class="fa fa-times"></i>
																		</a>
																</div>
														</div>
														<div class="ibox-content" id="shttable">
                              <div class="table-responsive">
														<table class="table table-striped table-bordered table-hover dataTables-example" >
														<thead>
																										<tr>
																												<th>No</th>
																												<th>Specimen No</th>
																												<th>Facility From</th>
																												<th>Date Created</th>
																												<th>Action</th>

                                                      </tr>
																								</thead>
                                              <tbody>
																								<?php $i =1;?>
																								@foreach($tsts1 as $tst)

																									<tr>
																									<td>{{$i}}</td>
																								  <td>{{$tst->specimen_no}}</td>
																									<td>{{$tst->FacilityName}}</td>
                                                  <td>{{$tst->created_at}}</td>
                                                  <td>
                                                  <a class="btn btn-primary btn-xs txtwht" href="{{route('perftestTrans',$tst->patTdid)}}">Perform Test</a>
                                                  </td>
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
