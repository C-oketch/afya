  @extends('layouts.facilityadmin2')
        @section('title', 'Test Prices')
        @section('styles')

        @endsection
        @section('content')

<div class="container">

  <div class="row">
      <div class="col-lg-12">
          <div class="tabs-container">
              <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#tab-1">Facility Test</a></li>
                  <li class=""><a data-toggle="tab" href="#tab-2">All Test</a></li>
              </ul>
              <div class="tab-content">
                  <div id="tab-1" class="tab-pane active">
                      <div class="panel-body">
                        <div class="table-responsive ibox-content">
                           <table class="table table-striped table-bordered table-hover dataTables-example" >
                         <thead>
                   					<tr>
                   						<th>#</th>
                   						<th>Name</th>
                               <th>Availability</th>
                               <th>Amount (KSH)</th>
                               <th>Options</th>
                               <th>Actions</th>
                   					</tr>
                   				</thead>
                          <?php

                        
                           $i =1;?>
                          @foreach($data as $item)
                <?php

                $tpo=DB::table('test_prices_other')
                ->leftJoin('testprice_other_option', 'test_prices_other.id', '=', 'testprice_other_option.tpo_id')
                ->select('test_prices_other.id','testprice_other_option.id as tpoid','testprice_other_option.amount',
                'testprice_other_option.name as tponame','testprice_other_option.status')
                ->where('test_prices_other.other_id',$item->testId)
                ->first();

                if($tpo->status == 1){ $status ='Yes';}elseif($tpo->status == 3){$status ='No';}else{ $status = ''; }
                 ?>

                          <tr class="item{{$i}}">
                            <td>{{$i}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$status}}</td>
                            <td>{{$tpo->amount}}</td>
                            <td>{{$tpo->tponame}}</td>
                            <td>
                           @if($tpo->amount)
                              <button class="edit-modal btn btn-info"  data-tpoid="{{$tpo->tpoid}}" data-id="{{$tpo->id}}"
                                data-name="{{$item->name}}" data-avala="{{$status}}"
                                data-amount="{{$tpo->amount}}" data-optionp="{{$tpo->tponame}}">
                                <span class="glyphicon glyphicon-edit"></span> EDIT
                              </button>
                            @endif


                            </td>
                          </tr>
                          <?php $i++; ?>
                          @endforeach
                        </table>


                      </div>
                  </div>
                  <div id="tab-2" class="tab-pane">
                      <div class="panel-body">
                          <strong>Donec quam felis</strong>

                          <p>Thousand unknown plants are noticed by me: when I hear the buzz of the little world among the stalks, and grow familiar with the countless indescribable forms of the insects
                              and flies, then I feel the presence of the Almighty, who formed us in his own image, and the breath </p>

                          <p>I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend, so absorbed in the exquisite
                              sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at the present moment; and yet.</p>
                      </div>
                  </div>
              </div>


          </div>
      </div>
</div>





  <div class="col-lg-12">
    <div class="ibox-title">
        <h5>OTHER IMAGING Test Price List</h5>
      </div>
       <div class="table-responsive ibox-content">
          <table class="table table-striped table-bordered table-hover dataTables-example" >
        <thead>
  					<tr>
  						<th>#</th>
  						<th>Name</th>
              <th>Availability</th>
              <th>Amount (KSH)</th>
              <th>Options</th>
              <th>Actions</th>
  					</tr>
  				</thead>
          <?php

          $admin= DB::table('facility_admin')->where('user_id', '=', Auth::user()->id)
            ->select('facilitycode')->first();
          $facility_id= $admin->facilitycode;
           $i =1;?>
  				@foreach($data as $item)
<?php

$tpo=DB::table('test_prices_other')
->leftJoin('testprice_other_option', 'test_prices_other.id', '=', 'testprice_other_option.tpo_id')
->select('test_prices_other.id','testprice_other_option.id as tpoid','testprice_other_option.amount',
'testprice_other_option.name as tponame','testprice_other_option.status')
->where('test_prices_other.other_id',$item->testId)
->first();

if($tpo->status == 1){ $status ='Yes';}elseif($tpo->status == 3){$status ='No';}else{ $status = ''; }
 ?>

  				<tr class="item{{$i}}">
  					<td>{{$i}}</td>
  					<td>{{$item->name}}</td>
            <td>{{$status}}</td>
            <td>{{$tpo->amount}}</td>
            <td>{{$tpo->tponame}}</td>
  					<td>
           @if($tpo->amount)
              <button class="edit-modal btn btn-info"  data-tpoid="{{$tpo->tpoid}}" data-id="{{$tpo->id}}"
  							data-name="{{$item->name}}" data-avala="{{$status}}"
                data-amount="{{$tpo->amount}}" data-optionp="{{$tpo->tponame}}">
  							<span class="glyphicon glyphicon-edit"></span> EDIT
  						</button>
            @endif
              <button class="add-modal btn btn-primary" data-id="{{$item->testId}}"
    							data-name="{{$item->name}}" >
    							<span class="glyphicon glyphicon-plus"></span>ADD
    						</button>

            </td>
  				</tr>
          <?php $i++; ?>
  				@endforeach
  			</table>
  		</div>
    </div>

  	</div>
<!-- Modal ADD-->
  	<div id="myModal" class="modal fade" role="dialog">
  		<div class="modal-dialog modal-lg">
  			<!-- Modal content-->
  			<div class="modal-content">
  				<div class="modal-header">
  					<button type="button" class="close" data-dismiss="modal">&times;</button>
  					<h4 class="modal-title"></h4>
  				</div>
  				<div class="modal-body">

      {!! Form::open(array('url' => 'saveother','method'=>'POST', 'class'=>'form-horizontal')) !!}
              <input type="hidden" name="_token" value="{{ csrf_token() }}">

  						<div class="form-group">
  							<div class="col-sm-10">
  								<input type="hidden" class="form-control" id="fid" name="tests_id" >
                </div>
  						</div>

  						<div class="form-group">
  							<label class="control-label col-sm-2" for="name">Test Name:</label>
  							<div class="col-sm-10">
  								<input type="text" class="form-control" id="n" disabled>
  							</div>
  						</div>
<br>
              <div class="form-group col-md-6">
                <label class="control-label col-sm-4" for="availability">Option:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="option1" name="option1">
                </div>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label col-sm-4" for="availability">Amount:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="amnt" name="amount1">
                </div>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label col-sm-4" for="availability">Option:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="optionp" name="option2">
                </div>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label col-sm-4" for="availability">Amount:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="amnt" name="amount2">
                </div>
              </div>


              <div class="form-group col-md-6">
                <label class="control-label col-sm-4" for="availability">Option:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="optionp" name="option3">
                </div>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label col-sm-4" for="availability">Amount:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="amnt" name="amount3">
                </div>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label col-sm-4" for="availability">Option:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="optionp" name="option4">
                </div>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label col-sm-4" for="availability">Amount:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="amnt" name="amount4">
                </div>
              </div>



  					<div class="modal-footer">
              <button class="btn btn-sm btn-primary"  type="submit"><strong>Submit</strong></button>
  						<!-- <button type="button" class="btn actionBtn" data-dismiss="modal">
  							<span id="footer_action_button" class='glyphicon'> </span>
  						</button> -->
  						<button type="button" class="btn btn-warning" data-dismiss="modal">
  							<span class='glyphicon glyphicon-remove'></span> Close
  						</button>
  					</div>
            {{ Form::close() }}
  				</div>
  			</div>
		  </div>
    </div>


    <div id="myModal2" class="modal fade" role="dialog">
  		<div class="modal-dialog">
  			<!-- Modal content-->
  			<div class="modal-content">
  				<div class="modal-header">
  					<button type="button" class="close" data-dismiss="modal">&times;</button>
  					<h4 class="modal-title"></h4>
  				</div>
  				<div class="modal-body">
  					<!-- <form class="form-horizontal" role="form">
              {!! Form::open(array('url' => 'registeruser','method'=>'POST')) !!} -->

              {!! Form::open(array('url' => 'editother','method'=>'POST', 'class'=>'form-horizontal')) !!}
  						<div class="form-group">
  							<!-- <label class="control-label col-sm-2" for="id">ID:</label> -->
  							<div class="col-sm-10">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  								<input type="hidden" class="form-control" id="fid2" name="tests_id" >
                  <input type="hidden" class="form-control" id="tpoid2" name="tpoid" >

                </div>
  						</div>

  						<div class="form-group">
  							<label class="control-label col-sm-2" for="name">Test Name:</label>
  							<div class="col-sm-10">
  								<input type="text" class="form-control" id="n2" disabled>

  							</div>
  						</div>
              <div class="form-group">
  							<label class="control-label col-sm-2" for="availability">Availability:</label>
  							<div class="col-sm-10">
  								<!-- <input type="text" class="form-control" id="av2" name="availability"> -->
                  <select class="form-control availability" id="av2" name="availability">
                      <option  value="1">Yes</option>
                      <option value="3">No</option>
                  </select>
  							</div>
  						</div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="availability">Charges(KSH):</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="amnt2" name="amount">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-2" for="availability">Option:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="optionp2" name="optionp">
                </div>
              </div>


  					<div class="modal-footer">
              <button class="btn btn-sm btn-primary"  type="submit"><strong>Submit</strong></button>

  						<!-- <button type="button" class="btn actionBtn" data-dismiss="modal">
  							<span id="footer_action_button" class='glyphicon'> </span>
  						</button> -->
             	<button type="button" class="btn btn-warning" data-dismiss="modal">
  							<span class='glyphicon glyphicon-remove'></span> Close
  						</button>
  					</div>
{{ Form::close() }}
  				</div>
  			</div>
		  </div>
    </div>
    @include('includes.default.footer')
    @endsection
    <!-- Section Body Ends-->
    @section('script')
     <!-- Page-Level Scripts -->

     <script type="text/javascript">
     function add_row()
     {
       data:$('#add_name').serializeArray(),
       $rowno=$("#employee_table tr").length;
       $rowno=$rowno+1;
       $("#employee_table tr:last").after("<tr id='row"+$rowno+"'><td><input type='text' name='members["+$rowno+"][name]' class='form-control' placeholder='Condition Name'></td><td><input type='text' name='members["+$rowno+"][status]' placeholder='Description' class='form-control'></td><td><input type='text' name='members["+$rowno+"][afya_user_id]' class='form-control'><input type='button' class='btn btn-danger' value='DELETE' onclick=delete_row('row"+$rowno+"')></td></tr>");
     }
     function delete_row(rowno)
     {
       $('#'+rowno).remove();
     }


     </script>
    <script src="{{ asset('js/otherIm.js') }}"></script>
    @endsection
