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
                                  <?php $i =1; ?>
                                  @foreach($factest as $item)
                        <?php
                         if($item->status == 1){ $status ='Yes';}elseif($item->status == 3){$status ='No';}else{ $status = ''; }
                         ?>

                                  <tr class="item{{$i}}">
                                    <td>{{$i}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$status}}</td>
                                    <td>{{$item->amount}}</td>
                                    <td>{{$item->tponame}}</td>
                                    <td>

                                      <button class="edit-modal btn btn-info"  data-tpoid="{{$item->tpoid}}" data-id="{{$item->id}}"
                                        data-name="{{$item->name}}" data-avala="{{$status}}"
                                        data-amount="{{$item->amount}}" data-optionp="{{$item->tponame}}">
                                        <span class="glyphicon glyphicon-edit"></span> EDIT
                                      </button>

                                      <a class ="btn btn-danger" href="{{route('deleteprocedure',$item->tpoid)}}">REMOVE</a>



                                    </td>
                                  </tr>
                                  <?php $i++; ?>
                                  @endforeach
                                </table>

                                  </div>
                              </div>
                          </div>
                          <div id="tab-2" class="tab-pane">
                              <div class="panel-body">
                                <div class="table-responsive ibox-content">
                                   <table class="table table-striped table-bordered table-hover dataTables-example" >
                                 <thead>
                           					<tr>
                           						<th>#</th>
                           						<th>Name</th>
                                       <th>Actions</th>
                           					</tr>
                           				</thead>
                                   <?php   $i =1; ?>
                           				@foreach($tests as $tsts)


                           				<tr class="item{{$i}}">
                           					<td>{{$i}}</td>
                           					<td>{{$tsts->name}}</td>
                           					<td>
                                       <button class="add-modal btn btn-primary" data-id="{{$tsts->testId}}"
                             							data-name="{{$tsts->name}}" >
                             							<span class="glyphicon glyphicon-plus"></span>ADD
                             						</button>

                                        <?php   $added =DB::table('procedure_prices')
                                           ->where('procedure_id',$tsts->testId)
                                           ->first();
                                          ?>
                                          @if($added)
                                        <button class="btn btn-info"><i class="fa fa-check"></i> ADDED</button>

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

              {!! Form::open(array('url' => 'addprocedure','method'=>'POST', 'class'=>'form-horizontal')) !!}
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

                      {!! Form::open(array('url' => 'editprocedure','method'=>'POST', 'class'=>'form-horizontal')) !!}
          						<div class="form-group">
          							<!-- <label class="control-label col-sm-2" for="id">ID:</label> -->
          							<div class="col-sm-10">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          								<input type="text" class="form-control" id="fid2" name="tests_id" >
                          <input type="text" class="form-control" id="tpoid2" name="tpoid" >

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
    <script src="{{ asset('js/otherIm.js') }}"></script>
    <!-- <script src="{{ asset('js/script.js') }}"></script> -->
    @endsection
