@extends('layouts.test')
@section('title', 'Tests')
@section('content')

<div class="container">


			<div class="col-lg-11 white-bg">
				<div class="ibox-content">
				<div class="col-lg-6">
			<h2>Patient : {{$info->firstName}} {{$info->secondName}}</h2>
			<ol class="breadcrumb">
			<li><a>@if($info->gender==1){{'Gender :'}}{{"Male"}}@else{{'Gender :'}}{{"Female"}}@endif</a></li>
			<li><a>{{'Age :'}}{{$info->age}}</a> </li>

			</ol>
			</div>
	<div class="col-lg-5">

		</ol>
	</div>
<?php
use Carbon\Carbon;
$today = Carbon::today();
$patTest =DB::table('patient_test')
 ->where([ ['dependant_id',$info->id],
          ['created_at','>=',$today],
				  ])
->first();
 ?>
@if($patTest)
@else
	<div class="col-lg-8 col-md-offset-1">
	<form class="form-horizontal" role="form" method="POST" action="/postpatientdep" novalidate>
 <input type="hidden" name="_token" value="{{ csrf_token() }}">
 <input type="hidden" class="form-control"  name="afyaId" value="{{$info->afyaId}}" >
 <input type="hidden" class="form-control"  name="depId" value="{{$info->depId}}" >

 <div class="form-group col-md-8 col-md-offset-1">
 		<label  class="col-md-6">Prescribing Doctor:</label>
 		 <select id="doc" name="doc" class="form-control doc" style="width: 100%"></select>
 </div>
	<div class="form-group col-md-8 col-md-offset-1">
			<label  class="col-md-6">Facility:</label>
			 <select id="facility" name="facility" class="form-control facility" style="width: 100%"></select>
	</div>

	<div class="col-lg-8">
		<button type="submit" class="btn btn-primary btn-sm">SUBMIT</button>
	</div>
{!! Form::close() !!}
</div>
@endif
	</div>
	</div>
	<br />



  <div class="col-lg-11">
		<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Test  List</h5>


			<div class="ibox-tools">

                <a href="{{URL('test.depshow',$info->depId)}}">
									<button class="btn btn-info">Show Added Tests</button>

                </a>
               </div>
						</div>
<div class="ibox-content">
       <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example" >
        <thead>
  					<tr>
  						<th>#</th>
							<th>Test</th>
  						<th>Categories</th>
              <th>Group</th>
              <th>Actions</th>
  					</tr>
  				</thead>
          <?php  $i =1;?>

  				@foreach($tsts as $item)
				<?php	$rst = DB::table('patient_test')
					->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
					->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
					->select('patient_test_details.*')
					->where([ ['patient_test_details.done', '=',0],
					          ['tests.id', '=',$item->testId],
										['patient_test.dependant_id', '=',$info->depId],
										])
					->first();
					?>
  				<tr class="item{{$item->testId}}">
						<td>{{$item->trId}}</td>
  					<td>{{$item->testname}}</td>
  					<td>{{$item->subcat}}</td>
            <td>{{$item->cat}}</td>
            <td> @if($rst)
	              <button class="btn btn-info">ADDED </button>
	              @else
	              <button class="add-modal btn btn-primary" data-id="{{$item->testId}}" data-dep="{{$info->depId}}"
									data-name="{{$item->testname}}" data-cat="{{$item->subcat}}" data-afya="{{$info->afyaId}}"
	    							<span class="glyphicon glyphicon-plus"></span>ADD
	    						</button>
	                @endif
						</td>
  				</tr>
          <?php $i++; ?>
  				@endforeach
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
 								<form class="form-horizontal" role="form" method="POST" action="/testadddep" novalidate>
 							 <input type="hidden" name="_token" value="{{ csrf_token() }}">

 									<div class="form-group">
 								<div class="form-group">
 										<div class="col-sm-10">
 											<input type="hidden" class="form-control" id="fid" name="testId" >
 											<input type="hidden" class="form-control" id="afya" name="afyaId" >
											<input type="hidden" class="form-control" id="dep" name="depId" >

 										</div>
 									</div>
 									 <div class="form-group">
 										<label class="control-label col-sm-2" for="name">Test Name:</label>
 										<div class="col-sm-10">
 											<input type="text" class="form-control" id="name" name="testname" readonly>
 											</div>
 									</div>
									<div class="form-group">
									 <label class="control-label col-sm-2" for="name">Test Category:</label>
									 <div class="col-sm-10">
										 <input type="text" class="form-control" id="cat" name="testname" readonly>
										 </div>
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

    @endsection
    <!-- Section Body Ends-->
    @section('script')
     <!-- Page-Level Scripts -->
  <script src="{{ asset('js/addtest.js') }}"></script>
    @endsection
