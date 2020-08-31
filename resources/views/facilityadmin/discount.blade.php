@extends('layouts.facilityadmin2')
@section('title', 'Test Discounts')
@section('content')
  <div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
              <div class="col-lg-8 col-lg-offset-2">
                  <div class="ibox float-e-margins">
                      <div class="ibox-title">
                          <h5>{{$data->name}}</h5>
                          <div class="ibox-tools">
                              <a class="collapse-link">
                                  <i class="fa fa-chevron-up"></i>
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
                      <div class="ibox-content">
                      <h3>Availability
                          <div class="stat-percent text-navy">{{$data->availability}}</div>
                      </h3>
                      <h3>Price
                          <div class="stat-percent text-navy">{{$data->amount}}</div>
                      </h3>
                  </div>

                  </div>
              </div>
              <?php

              $datadisc =DB::table('lab_test_discount')
              ->select('reason','id','amount','created_at','status')
              ->Where([['test_price_id',$data->id],['facility_id',$data->facility_id],])
              ->get();
              $userId=Auth::user()->id;
              ?>
              <div class="col-lg-8 col-lg-offset-2">
                  <div class="ibox float-e-margins">
                      <div class="ibox-title">
                          <h5>{{$data->name}} Tests Discounts</h5>
                          <div class="ibox-tools">
                              <a class="collapse-link">
                                  <i class="fa fa-chevron-up"></i>
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
                      <div class="ibox-content">

                    <div class="row">
                        <table class="table table-hover margin bottom">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Reason</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Update</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php  $i =1;?>
                              @foreach($datadisc as $item)
                              <tr>
                                <td>{{$i}}</td>
                                <td>{{$item->reason}}</td>
                                <td>{{$item->amount}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>@if($item->status==1) <span class="label label-primary">Active</span>
                                  @elseif($item->status==0) <span class="label label-warning">Inactive</span>
                                  @else N/A @endif
                                </td>
                                <td>  <button class="priceupdate-modal btn btn-info btn-xs" data-id="{{$item->id}}" data-testid="{{$data->testId}}"
                                      data-name="{{$data->name}}"   data-reason="{{$item->reason}}"   data-amount="{{$item->amount}}">
                                      <span class="glyphicon glyphicon-plus"></span>Update
                                    </button>
                                </td>
                             </tr>
                                <?php $i++; ?>
                                @endforeach
                              </tbody>
                            </table>
                          </div>

                          <div class="text-center">
                            <a data-toggle="modal" class="btn btn-primary" href="#modal-form">Add New Discount</a>
                          </div>
                          <div id="modal-form" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-body">
                                  <div class="row">
                                    <p>Add New Discounts.</p>

                                    <form role="form" role="form" method="POST" action="/discountadd">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                      <div class="form-group"><label>Reason</label>
                                         <input type="text" placeholder="Enter reason" name="reason" class="form-control" required>
                                       </div>
                                       <div class="form-group"><label>Amount</label>
                                         <input type="text" placeholder="Enter amount in KSH" name="amount" class="form-control" required>

                                          <input type="hidden"  name="test_price_id" value="{{$data->id}}">
                                          <input type="hidden"  name="facility_id" value="{{$data->facility_id}}">
                                          <input type="hidden"  name="user_id" value="{{$userId}}">
                                          <input type="hidden"  name="testId" value="{{$data->testId}}">


                                       </div>
                                       <div class="form-group"><label>Status:</label>
                           							 <select class="form-control" name="status">
                                               <option value="1">Active</option>
                                               <option value="0">Inactive</option>
                                           </select>
                                      </div>

                                    <div>
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Submit</strong></button>
                                      </div>
                                    </form>


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
                                       <form class="form-horizontal" role="form" method="POST" action="/discountupdate">
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">


                                      <div class="form-group">
                                       <label class="control-label col-sm-2">Test:</label>
                                       <div class="col-sm-10">
                                         <input type="text" class="form-control" id="name" readonly>
                                         </div>
                                     </div>
                                         <div class="form-group">
                                           <div class="col-sm-10">
                                             <input type="hidden" class="form-control" id="id" name="test_discount_id" >
                                             <input type="hidden" class="form-control" id="testId" name="testId" >


                                           </div>
                                         </div>
                                         <div class="form-group">
                                          <label class="control-label col-sm-2">Reason:</label>
                                          <div class="col-sm-10">
                                            <input type="text" class="form-control" id="reason" readonly>
                                            </div>
                                        </div>

                                          <div class="form-group">
                                           <label class="control-label col-sm-2">Amount(ksh):</label>
                                           <div class="col-sm-10">
                                             <input type="text" class="form-control" id="amount" name="amount" >
                                             </div>
                                         </div>
                                         <div class="form-group">
                                           <label class="control-label col-sm-2">Status:</label>
                                            <div class="col-sm-10"><select class="form-control" name="status">
                                                 <option value="1">Active</option>
                                                 <option value="0">Inactive</option>
                                             </select>
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
              </div>
          </div>
      </div>

        </div>
<!--container-->

@endsection
@section('script')
 <!-- Page-Level Scripts -->
 <!-- <script src="{{ asset('js/app.js') }}"></script> -->
<script src="{{ asset('js/script.js') }}"></script>
@endsection
