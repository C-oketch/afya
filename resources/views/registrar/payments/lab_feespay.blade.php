@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')

<?php

$regid = Auth::id();

$feereg = DB::table('users')->select('name')->where('id',$regid)->first();
$regname=$feereg->name;
$paymentmode = DB::table('payment_options')
            ->select('name','id')
            ->get();

$insurance = DB::table('insurance_companies')
          ->select('company_name','id')
          ->get();
$ptids = DB::table('patient_test_details')
        ->select('patient_test_id','id','appointment_id')
        ->where('id',$ptdidl)->first();

$ptid =$ptids->patient_test_id;
$prdid =$ptids->id;
$appid =$ptids->appointment_id;
?>
  @include('includes.registrar.topnavbar_v2')

            <div class="wrapper wrapper-content">
                <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <!-- <h5>Consultation Fee</h5> -->
                            <div class="ibox-tools">
                        <a href="{{ URL('registrar.shows_pay',$user->appid) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-sm-4"><h3 class="m-t-none m-b"></h3>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Details</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                             <td>{{$lab->name}}</td>
                                            </tr>
                                          </tbody>
                                        </table>
                                    </div><!-- /table-responsive -->
                                </div>
                                <div class="col-sm-6"><h4>Payment</h4>

                                  {!! Form::open(array('url' => 'regpaylab','method'=>'POST')) !!}
                                  <input type="hidden" value="{{$user->id}}" name="afya_user_id">
                                  <input type="hidden" value="{{$appid}}" name="appointment">
                                  <input type="hidden" value="{{$ptid}}" name="ptid">
                                  <input type="hidden" value="{{$prdid}}" name="prdid">
                                  <input type="hidden" value="{{$user->appid}}" name="cappid">


                                  <div class="form-group">
                                    <label>Payment choices</label>
                                        <select class="form-control select2_demo_1" id="dropdown" name="pchoice">
                                        <option selected value="">Select choice</option>
                                        @foreach($labprice as $otp)
                                        <option value="{{$otp->amount}}">{{$otp->name}}</option>
                                         @endforeach
                                      </select>
                                    </div>

                                    <div class="form-group">
                                      <label>Amount :</label>
                                    <input type="text" value="" class="form-control m-b" id="receiver" name="amount" >
                                  </div>


                                  <div class="form-group">
                                    <label>Payment Mode</label>
                                        <select class="form-control  select2_demo_1" id="pmode" name="mode" required>
                                        <option selected value="">Select choice</option>
                                        @foreach($paymentmode as $mode)
                                        <option value="{{$mode->id}}">{{$mode->name}}</option>
                                         @endforeach
                                      </select>
                                    </div>


                                    <div class="form-group" id="insco">
                                      <label>Insurance Company</label>
                                          <select class="form-control select2_demo_1"  name="company">
                                          <option selected value="">Select choice</option>
                                          @foreach($insurance as $ins)
                                          <option value="{{$ins->id}}">{{$ins->company_name}}</option>
                                           @endforeach
                                        </select>
                                      </div>

                                      <div class="form-group" id="policy">
                                      <label>Policy No :</label>
                                      <input type="text"  class="form-control m-b" name="policy_no" >
                                      </div>

                                      <div class="form-group" id="transact">
                                      <label>Transaction No :</label>
                                      <input type="text"  class="form-control m-b" name="transaction" >
                                      </div>


                                  <button type="submit" class="btn btn-primary btn-sm pull-right"> Submit</button>
                                     {!! Form::close() !!}

                            </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
      </div>



                @endsection
                  @section('script-reg')
                <script>
                  $(document).ready(function(){
                    // $("#myselect").select2({ width: '100%' });
                      $(".select2_demo_1").select2({ width: '100%' });

                    $("#dropdown").change(function(){
                     $("#receiver").val($(this).val());
                        });

                            $(function() {
                            $('#insco').hide();
                            $('#policy').hide();
                            $('#transact').hide();
                            $('#pmode').change(function(){

                            if($('#pmode').val() == '1') {
                            $('#insco').hide();
                            $('#transact').hide();
                            $('#policy').hide();

                          } else if($('#pmode').val() == '4') {
                                $('#insco').hide();
                                $('#policy').hide();
                                $('#transact').show();
                         }  else if($('#pmode').val() == '5') {
                                 $('#insco').hide();
                                 $('#policy').hide();
                                 $('#transact').show();
                          }else if($('#pmode').val() == '6') {
                                $('#insco').hide();
                                $('#policy').hide();
                                $('#transact').show();
                        }else{
                            $('#insco').show();
                            $('#transact').hide();
                            $('#policy').show();
                          }


                            });
                            });
                });
                  </script>


                  <script>
            if($('#pmode').val() == '4') {
                  $('#insco').hide();

                } else {
                  $('#insco').show();
                  $('#transact').show();
                }

                    </script>

            @endsection
