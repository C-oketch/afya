@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')

<?php

$regid = Auth::id();

$feereg = DB::table('users')->select('name')->where('id',$regid)->first();
$regname=$feereg->name;
$paymentmode = DB::table('payment_options')
            ->select('name','id')
            ->where('id','<>', 6)
            ->get();

?>
  @include('includes.registrar.topnavbar_v2')

            <div class="wrapper wrapper-content">
                <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Medical Report Fee</h5>
                            <div class="ibox-tools">
                        <a href="{{ URL('registrar.shows_pay',$user->appid) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-sm-6 b-r"><h3 class="m-t-none m-b"></h3>

                                    <div class="table-responsive m-t">
                                        <table class="table invoice-table">
                                            <thead>
                                            <tr>
                                                <th>Details</th>
                                                <th>Total Price</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                            <td>Medical Report fee</td>
                                             <td>{{$cnst->medical_report_fee}}</td>
                                            </tr>
                                          </tbody>
                                        </table>
                                    </div><!-- /table-responsive -->
                                </div>
                                <div class="col-sm-6"><h4>Payment</h4>

                                  {!! Form::open(array('url' => 'medicalfeep','method'=>'POST')) !!}
                                  <input type="hidden" value="{{$user->id}}" name="afya_user_id">
                                  <input type="hidden" value="{{$user->appid}}" name="appointment">
                                  <input type="hidden" value="{{$registrar->FacilityCode}}" name="facility">

                                  <div class="form-group"><label class="col-sm-6 control-label">Payment choices</label>
                                      <div class="col-sm-6">
                                        <select class="form-control m-b" id="choice" name="choice" required>
                                        <option selected="" value="">Select choice</option>
                                        <option value="free">Free</option>

                                         <option value="normal">New Patient</option>
                                         <option value="old">Old Patient</option>

                                       <option value="discount">Discount</option>
                                      </select>
                                    </div>
                                    </div>

                                    <div class="form-group  choose free" style="display:none">
                                    <div class="col-sm-6">
                                      <input type="hidden" value="" class="form-control m-b" name="amount1">
                                    </div>
                                    </div>


                                  <div class="form-group  choose normal" style="display:none">
                                    <div class="form-group"><label class="col-sm-6 control-label">Amount :</label>
                                  <div class="col-sm-6">
                                    <input type="text" value="{{$cnst->medical_report_fee}}" class="form-control m-b" name="amount2" readonly>
                                  </div>
                                  </div>
                                  <div class="form-group"><label class="col-sm-6 control-label">Payment Mode :</label>
                                      <div class="col-sm-6"><select class="form-control m-b pay_mode" name="account1">
                                        @foreach($paymentmode as $fee)
                                      <option value="{{$fee->id}}">{{$fee->name}}</option>
                                        @endforeach
                                        <?php
                                        if((isset($user->nhif) && $user->nhif != 'N/A'))
                                        {
                                        $nhif = DB::table('payment_options')
                                                    ->select('name','id')
                                                    ->where('id','=', 6)
                                                    ->first();

                                         ?>
                                         <option value="{{$nhif->id}}">{{$nhif->name}}</option>
                                       <?php
                                        }
                                          ?>
                                      </select>
                                    </div>
                                    </div>

                                    <div class="form-group  2 insurance" style="display:none">
                                      <div class="form-group">
                                        <?php
                                        $insurances=DB::table('insurance_companies')->get();
                                        if(isset($user->insurance_company_id))
                                        {
                                        $ins_selected = DB::table('insurance_companies')
                                                     ->select('company_name')
                                                     ->where('id', '=', $user->insurance_company_id)
                                                     ->first();
                                       $insurer = $ins_selected->company_name;
                                         }
                                         ?>
                                      <label class="col-sm-6 control-label">Insurance Company</label>
                                          <div class="col-sm-6">
                                            <?php
                                             if(isset($user->insurance_company_id))
                                             {
                                             ?>
                                             <textarea class="form-control m-b" name="insurance_company1" >{{$insurer}}</textarea>

                                          <?php }
                                          else
                                          {
                                           ?>
                                      <select class="form-control m-b" name="insurance_company2" >
                                       <option selected disabled value="">Select insurance company</option>

                                        @foreach ($insurances as $insurance)
                                        <option value="{{$insurance->id}}">{{$insurance->company_name}}</option>
                                        @endforeach
                                      </select>
                                      <?php
                                      }
                                      ?>
                                      </div>
                                      </div>


                                      <div class="form-group"><label class="col-sm-6 control-label">Policy No :</label>
                                    <div class="col-sm-6">
                                      <?php
                                      if(isset($user->insurance_company_id))
                                      { ?>
                                      <input type="text" value="{{$user->policy_no}}" class="form-control m-b" name="policy_no1" readonly>
                                      <?php
                                    }
                                    else
                                    {
                                       ?>
                                       <input type="text" class="form-control m-b" name="policy_no2" >
                                       <?php
                                        } ?>
                                    </div>
                                    </div>

                                      </div>

                                    <div class="form-group  5 mpesa" style="display:none">
                                      <div class="form-group"><label class="col-sm-6 control-label">Transaction No :</label>

                                    <div class="col-sm-6">
                                      <input type="text"  class="form-control m-b" name="transaction_no1" >
                                      </div>

                                      </div>
                                      </div>


                                  </div>


                                 <div class="form-group  choose old" style="display:none">
                                   <div class="form-group"><label class="col-sm-6 control-label">Amount :</label>
                                 <div class="col-sm-6">
                                   <input type="text" value="{{$cnst->medical_report_fee}}" class="form-control m-b" name="amount4" readonly>
                                 </div>
                                 </div>
                                 <div class="form-group"><label class="col-sm-6 control-label">Payment Mode :</label>
                                     <div class="col-sm-6"><select class="form-control m-b pay_mode" name="account3">
                                       @foreach($paymentmode as $fee)
                                     <option value="{{$fee->id}}">{{$fee->name}}</option>
                                       @endforeach

                                       <?php
                                       if((isset($user->nhif) && $user->nhif != 'N/A'))
                                       {
                                       $nhif = DB::table('payment_options')
                                                   ->select('name','id')
                                                   ->where('id','=', 6)
                                                   ->first();

                                        ?>
                                        <option value="{{$nhif->id}}">{{$nhif->name}}</option>
                                      <?php
                                       }
                                         ?>
                                     </select>
                                   </div>
                                   </div>

                                   <div class="form-group  2 insurance" style="display:none">
                                     <div class="form-group">
                                       <?php
                                       $insurances=DB::table('insurance_companies')->get();
                                       if(isset($user->insurance_company_id))
                                       {
                                       $ins_selected = DB::table('insurance_companies')
                                                    ->select('company_name')
                                                    ->where('id', '=', $user->insurance_company_id)
                                                    ->first();
                                      $insurer = $ins_selected->company_name;
                                        }
                                        ?>
                                     <label class="col-sm-6 control-label">Insurance Company</label>
                                         <div class="col-sm-6">
                                           <?php
                                            if(isset($user->insurance_company_id))
                                            {
                                            ?>
                                            <textarea class="form-control m-b" name="insurance_company3" >{{$insurer}}</textarea>

                                         <?php }
                                         else
                                         {
                                          ?>
                                     <select class="form-control m-b" name="insurance_company4" >
                                      <option selected disabled value="">Select insurance company</option>

                                       @foreach ($insurances as $insurance)
                                       <option value="{{$insurance->id}}">{{$insurance->company_name}}</option>
                                       @endforeach
                                     </select>
                                     <?php
                                     }
                                     ?>
                                     </div>
                                     </div>


                                     <div class="form-group"><label class="col-sm-6 control-label">Policy No :</label>
                                   <div class="col-sm-6">
                                     <?php
                                     if(isset($user->insurance_company_id))
                                     { ?>
                                     <input type="text" value="{{$user->policy_no}}" class="form-control m-b" name="policy_no3" readonly>
                                     <?php
                                   }
                                   else
                                   {
                                      ?>
                                      <input type="text" class="form-control m-b" name="policy_no4" >
                                      <?php
                                       } ?>
                                   </div>
                                   </div>

                                     </div>

                                   <div class="form-group  5 mpesa" style="display:none">
                                     <div class="form-group"><label class="col-sm-6 control-label">Transaction No :</label>

                                   <div class="col-sm-6">
                                     <input type="text"  class="form-control m-b" name="transaction_no2" >
                                     </div>

                                     </div>
                                     </div>


                                 </div>



                                  <div class="form-group  choose discount" style="display:none">
                                    <div class="form-group"><label class="col-sm-6 control-label">Amount :</label>
                                  <div class="col-sm-6">
                                    <input type="text" value="" class="form-control m-b" name="amount3">
                                  </div>
                                  </div>
                                  <div class="form-group"><label class="col-sm-6 control-label">Payment Mode :</label>
                                      <div class="col-sm-6"><select class="form-control m-b pay_mode" name="account2">
                                        @foreach($paymentmode as $fee)
                                      <option value="{{$fee->id}}">{{$fee->name}}</option>
                                        @endforeach
                                        <?php
                                        if((isset($user->nhif) && $user->nhif != 'N/A'))
                                        {
                                        $nhif = DB::table('payment_options')
                                                    ->select('name','id')
                                                    ->where('id','=', 6)
                                                    ->first();

                                         ?>
                                         <option value="{{$nhif->id}}">{{$nhif->name}}</option>
                                       <?php
                                        }
                                          ?>
                                      </select>
                                    </div>
                                    </div>

                                    <div class="form-group  2 insurance" style="display:none">
                                      <div class="form-group">
                                        <?php
                                        $insurances=DB::table('insurance_companies')->get();
                                        if(isset($user->insurance_company_id))
                                        {
                                        $ins_selected = DB::table('insurance_companies')
                                                     ->select('company_name')
                                                     ->where('id', '=', $user->insurance_company_id)
                                                     ->first();
                                       $insurer = $ins_selected->company_name;
                                         }
                                         ?>
                                      <label class="col-sm-6 control-label">Insurance Company</label>
                                          <div class="col-sm-6">
                                            <?php
                                             if(isset($user->insurance_company_id))
                                             {
                                             ?>
                                             <textarea class="form-control m-b" name="insurance_company5" >{{$insurer}}</textarea>

                                          <?php }
                                          else
                                          {
                                           ?>
                                      <select class="form-control m-b" name="insurance_company6" >
                                       <option selected disabled value="">Select insurance company</option>

                                        @foreach ($insurances as $insurance)
                                        <option value="{{$insurance->id}}">{{$insurance->company_name}}</option>
                                        @endforeach
                                      </select>
                                      <?php
                                      }
                                      ?>
                                      </div>
                                      </div>


                                      <div class="form-group"><label class="col-sm-6 control-label">Policy No :</label>
                                    <div class="col-sm-6">
                                      <?php
                                      if(isset($user->insurance_company_id))
                                      { ?>
                                      <input type="text" value="{{$user->policy_no}}" class="form-control m-b" name="policy_no5" readonly>
                                      <?php
                                    }
                                    else
                                    {
                                       ?>
                                       <input type="text" class="form-control m-b" name="policy_no6" >
                                       <?php
                                        } ?>
                                    </div>
                                    </div>

                                      </div>

                                    <div class="form-group  5 mpesa" style="display:none">
                                      <div class="form-group"><label class="col-sm-6 control-label">Transaction No :</label>

                                    <div class="col-sm-6">
                                      <input type="text"  class="form-control m-b" name="transaction_no3" >
                                      </div>

                                      </div>
                                      </div>


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
                    $("#choice").change(function(){
                        $(this).find("option:selected").each(function(){
                            var optionValue = $(this).attr("value");
                            if(optionValue){
                                $(".choose").not("." + optionValue).hide();
                                $("." + optionValue).show();
                            } else{
                                $(".choose").hide();
                            }
                        });
                    }).change();
                });
                  </script>

                  <script>
                  $(document).ready(function(){
                    $(".pay_mode").change(function(){
                        $(this).find("option:selected").each(function(){
                            var optionValue = $(this).attr("value");
                            if(optionValue){
                                $(".mpesa").not("." + optionValue).hide();
                                $(".insurance").not("." + optionValue).hide();
                                $("." + optionValue).show();
                            } else{
                                $(".mpesa").hide();
                                $(".insurance").hide();
                            }
                        });
                    }).change();
                });
                  </script>
            @endsection
