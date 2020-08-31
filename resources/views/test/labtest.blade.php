<?php
$tsts = DB::table('test_categories')
->Join('test_subcategories', 'test_categories.id', '=', 'test_subcategories.categories_id')
->Join('tests', 'test_subcategories.id', '=', 'tests.sub_categories_id')
->Join('test_ranges', 'tests.id', '=', 'test_ranges.tests_id')
->select('test_categories.name as cat','test_subcategories.name as subcat','tests.id as testId',
'tests.name as testname','test_ranges.id as trId')
->where('test_ranges.facility_id', '=',$facid->facilitycode)
->orderBy('tests.name', 'asc')
->get();


?>
<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
		<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Test  List</h5>
<div class="ibox-tools">

                <a href="{{URL('test.show',$info->id)}}">
									<button class="btn btn-info">Show Added Tests</button>

                </a>
								<a href="{{URL('test')}}" class="btn btn-primary btn-sm">Back</a>

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
                    ['patient_test_details.deleted', '=',0],
					          ['tests.id', '=',$item->testId],
										['patient_test.afya_user_id', '=',$info->id],
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
	              <button class="add-modal btn btn-primary" data-id="{{$item->testId}}"
									data-name="{{$item->testname}}" data-cat="{{$item->subcat}}" data-ptid="{{$pt_id}}" data-afya="{{$info->id}}"
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
 								<form class="form-horizontal" role="form" method="POST" action="/testadd" novalidate>
 							 <input type="hidden" name="_token" value="{{ csrf_token() }}">

 									<div class="form-group">
 								<div class="form-group">
 										<div class="col-sm-10">
 											<input type="hidden" class="form-control" id="fid" name="testId" >
 											<input type="hidden" class="form-control" id="afya" name="afyaId" >
											<input type="hidden" class="form-control" id="ptid" name="patient_test_id" >
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
                 <div class="form-group ">
                 <label class="control-label col-sm-2">Doctor Note(For test):</label>
                 <div class="col-sm-10"><textarea rows="4" name="docnote" id="docnote" cols="50" class="form-control"></textarea>
                 </div></div>



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
