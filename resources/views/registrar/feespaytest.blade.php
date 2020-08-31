@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')

@include('includes.registrar.topnavbar_v2')
<?php

$regid = Auth::id();

$feereg = DB::table('users')->select('name')->where('id',$regid)->first();
$regname=$feereg->name;
$paymentmode = DB::table('payment_options')->select('name','id')->get();

?>
<div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
          <h2>Invoice</h2>
          <ol class="breadcrumb">
              <li>
                  <a href="index.html">Home</a>
              </li>
              <li>
                  Fees
              </li>
              <li class="active">
                  <strong>Payments</strong>
              </li>
          </ol>
      </div>
      <div class="col-lg-4">
          <div class="title-action">
              <!-- <a href="#" class="btn btn-white"><i class="fa fa-pencil"></i> Edit </a>
              <a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save </a> -->
              <a href="{{ URL::to('fees') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </a>
              <a href="{{route('registrar.labreceipt',$user->appid)}}" class="btn btn-primary"><i class="fa fa-print"></i>View Receipt</a>
          </div>
      </div>
  </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Lab Test Fees</h5>
                            <div class="ibox-tools">

                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-8 col-md-offset-2"><h3 class="m-t-none m-b"></h3>

                                    <div class="table-responsive m-t">
                                        <table class="table invoice-table">
                                            <thead>
                                            <tr>
                                                <th>Details</th>
                                                <th>Total Price</th>
                                                <th>Total Price</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                              <?php $i =1;

                                          if($tsts){
                                              ?>

                                              @foreach($tsts as $tst)

                                                <tr class="item{{$tst->AppId}}">
                                                <td>{{$tst->tname}}</td>
                                                <td>{{$tst->amount}}</td>

                                                <?php
                                                $datadetails = DB::table('payments')
                                                ->Where([['appointment_id',$tst->AppId],
                                                         ['lab_id',$tst->patTdid],
                                                         ['payments_category_id',2],])
                                                ->first();
                                                ?>
                                                @if($datadetails)
                                                <td><button class="btn btn-primary">Paid</button></td>
                                                @else
                                                <td>
                                                <button class="add-modal btn btn-primary" data-appid="{{$tst->AppId}}" data-amount="{{$tst->amount}}"
                                                    data-name="{{$tst->tname}}" data-ptid="{{$tst->ptid}}" data-ptdid="{{$tst->patTdid}}">
                                                    <span class="glyphicon glyphicon-plus"></span>ADD
                                                  </button>
                                                </td>
                                                @endif
                                                </tr>
                                              <?php $i++; ?>
                                                @endforeach
                                         <?php } ?>
                                          </tbody>
                                        </table>
                                    </div><!-- /table-responsive -->
                                </div>

                        </div>
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
              <!-- <form class="form-horizontal" role="form"> -->
                  {!! Form::open(array('url' => 'regpaytest','method'=>'POST', 'class'=>'form-horizontal')) !!}
              <input type="hidden" name="_token" value="{{ csrf_token() }}">

              <input type="hidden" class="form-control" id="appid" name="appointment" >
              <input type="hidden" class="form-control" id="ptid" name="ptid" >
              <input type="hidden" class="form-control" id="ptdid" name="ptdid" >




          <div class="form-group">
            <label class="col-md-4">Test Name:</label>
            <div class="col-md-8">
            <input type="text" class="form-control" id="m" readonly>
          </div>
        </div>

        <div class="form-group">
              <label class="col-sm-4">Amount :</label>
            <div class="col-sm-8">
              <input type="text" id="n" class="form-control" name="amount">
            </div>
            </div>
            <div class="form-group"><label class="col-sm-4">Payment Mode :</label>
                <div class="col-sm-8"><select class="form-control" name="mode">
                  @foreach($paymentmode as $fee)
                  <option value="{{$fee->id}}">{{$fee->name}}</option>
                  @endforeach
                </select>
              </div>
              </div>
  </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">SUBMIT</button>
            {!! Form::close() !!}
            </div>
            </div>
            </div>
            </div>


      @endsection
                @section('script-reg')
                 <!-- Page-Level Scripts -->
                <script src="{{ asset('js/lab_id.js') }}"></script>

                @endsection
