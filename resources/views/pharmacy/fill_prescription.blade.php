@extends('layouts.pharmacy')
@section('title', 'Pharmacy')
@section('content')

        <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">

          <?php

          $user_id = Auth::user()->id;

          $data = DB::table('pharmacists')
                    ->where('user_id', $user_id)
                    ->first();

          $facility = $data->premiseid;
           ?>

          <!-- Display patient allergies if any -->


                  <!-- <br /><br /> -->
          <!-- Display chronic diseases if any -->


                  <!-- <br /><br /> -->
          <!-- Show medication patient is taking currently-->
          <?php
          if(empty($drugs))
          {
           ?>
           <div class="ibox-title">
           <h5>Current Medication : NONE</h5>
            </div>
            <?php
          }
          else
          {
             ?>

             <div class="ibox-title">
             <h5>Current Medication.</h5>
              </div>

           <div class="table-responsive">
             <table class="table table-striped table-bordered table-hover dataTables-example" >
             <thead>

               <tr>
                   <th>No</th>
                   <th>Drug</th>
                   <!-- <th>Dosage Prescribed</th> -->
                   <th>Dosage Given</th>
                   <!-- <th>Route</th>
                   <th>Frequency</th> -->
               </tr>
               </thead>
               <tbody>
                 <?php
                 $i = 1;
                 foreach ($drugs as $drug)
                 {
                   ?>
               <tr class="gradeX">
               <td>{{$i}}</td>
               <td>{{$drug->drugname}}</td>
               <td>{{$drug->strength}}{{-- $drug->strength_unit --}}</td>
               <td>{{$drug->dose_given}}{{-- $drug->strength_unit --}}</td>
               <!-- <td>{{-- $drug->route_name --}} </td>
               <td>{{-- $drug->freq_name --}} </td> -->

               </tr>
               <?php
               $i++;
                }
              ?>
             </tbody>
            <tfoot>
              <!-- <tr>
                <th>Drug</th>
                <th>Dosage Prescribed</th>
                <th>Dosage Given</th>
                <th>Route</th>
                <th>Frequency</th>
              </tr> -->
              </tfoot>
              </table>
                  </div>
              <?php
              }
               ?>

               <br /><br />

            <div class="col-lg-9">
              <div class="ibox-content">

              {!! Form::open(array('route' => 'pharmacy.store','method'=>'POST','class'=>'form-horizontal')) !!}

            <input type="hidden" name="p_id" value="<?php echo $results->the_id; ?>" />
            <input type="hidden" name="presc_id" value="<?php echo $results->presc_id; ?>" />
            <input type="hidden" name="afyamessage_id" value="<?php echo $afyamessage_id; ?>" />
            <?php
            $query1 = DB::table('prescription_filled_status')
                    ->select(DB::raw('SUM(dose_given) AS total_given'))
                    ->where('presc_details_id','=',$results->presc_id)
                    ->first();
            $count1 = $query1->total_given;

            $query2 = DB::table('prescription_details')
                    ->where('id', '=', $results->presc_id)
                    ->first();
            $count2 = $query2->strength;
            $final = $count2 - $count1;
             ?>

           <div class="form-group"><label>Drug</label> <input type="text" name="drug" value="{{$results->drugname}}"  class="form-control" readonly></div>
           <div class="form-group"><label>Strength</label> <input type="text" id="strength22" value="{{$final}}"  class="form-control" readonly></div>
           <div class="form-group">
               <label>Is the drug prescribed issued as written?</label>

           <div class="radio radio-info radio-inline">
          <input type="radio" name="availability" value="Yes" id="yeah" required="">
          <label for="radio3">
              Yes
          </label>
                </div>
          <div class="radio radio-info radio-inline">
              <input type="radio" name="availability" value="No" id="nah" required="">
              <label for="radio4">
                  No
              </label>
          </div>
          </div>

              <script type="text/javascript">
                     $('input[type="radio"]').attr('checked', 'checked').on( "change", function(){
                         if($(this).attr("value")=="No")
                         {
                             $(".Box1").show('slow');
                             $(".Box").hide('slow');
                         }

                         if($(this).attr("value")=="Yes")
                         {
                             $(".Box").show('slow');
                             $(".Box1").hide('slow');
                         }
                     });
                  $('input[type="radio"]').trigger('click');

               </script>

               <div class="Box" style="display:none">

                 <div class="form-group">
                  <label>Weight</label>
                   <select class="form-control" id="weight1" name="weight1" required="">
                     <option selected disabled>Select drug strength </option>
                     <?php $Strengths=DB::table('strength')->distinct()->get(['strength']); ?>
                       @foreach($Strengths as $Strengthz)
                         <option value="{{$Strengthz->strength}}">{{ $Strengthz->strength  }}  </option>
                      @endforeach
                  </select>
                  </div>

               <!-- <div class="form-group"><label>Weight</label> <input type="number" id="weight1" name="weight1"  class="form-control"></div> -->

               <div class="form-group"><label>Quantity</label> <input type="number" name="quantity" id="quantity" class="form-control"></div>

               <!-- <div class="alert alert-danger" style="display: none">
                                <strong>Dose given has exceeded {{$final}}</strong>
               </div> -->

               <div class="alert alert-danger" id="alert1" role="alert" style="display:none">
              <h4 class="alert-heading">Danger!</h4>
              <p> Dose given has exceeded</p>
              <p>{{$final}}</p>
              </div>

              <div class="alert alert-danger" id="alert2" role="alert" style="display:none">
             <h4 class="alert-heading">Danger!</h4>
             <p> Dose given is less than</p>
             <p>{{$final}}</p>
             </div>

               <div class="form-group"><label>Dose Given</label> <input type="number" id="sub2" name="dose_given1"  class="form-control" readonly ></div>

               <!-- <div class="form-group" id="subs" style="display:none">
                 <label>Reason</label>
                  <select class="form-control" name="reason22" id="first_reason">
                    <option value="" selected disabled>Select reason</option>-->
                   <?php
                  //  $reasons = DB::table('substitution_reason')->distinct()->get(['reason','id']);
                  //
                  //  foreach($reasons as $reason)
                  //  {
                     ?>
                          <!-- <option value='{{-- $reason->id --}}'>{{--$reason->reason --}}</option> -->
                   <?php
                 //}
                   ?>
                 <!--</select>
               </div> -->

               <?php
               $prices = DB::table('inventory')
                        ->select('recommended_retail_price')
                        ->where('drug_id', '=', $results->drug_id)
                        ->orderBy('updated_at', 'desc')
                        ->first();
                $recommended_price = $prices->recommended_retail_price;
                ?>

               <div class="form-group"><label>Recommended Price</label> <input type="number" id="rrp1" name="rec_price" value="{{$recommended_price}}"  class="form-control" disabled></div>

               <div class="form-group"><label>Price</label> <input type="number" name="price" id="price" class="form-control" ></div>

               <div class="form-group">
                 <label>Payment options</label>
                  <select class="form-control" name="payment_options1" id="pay_option1" >
                    <option value="" selected disabled>Select payment option</option>
                   <?php $options = DB::table('payment_options')->distinct()
                                ->join('pharmacy_payment', 'pharmacy_payment.option_id', '=', 'payment_options.id')
                                ->where('pharmacy_payment.pharmacy_id', '=', $facility)
                                ->get(['payment_options.name','pharmacy_payment.markup']); ?>
                   @foreach($options as $option)
                          <option value='{{$option->markup}}'>{{$option->name}}</option>
                   @endforeach
                 </select>

               </div>

               <div class="form-group"><label>Total</label> <input type="number" name="total" id="total" class="form-control" readonly ></div>

               <div class="form-group">
                 <label class="font-normal">Prescription duration</label>
                 <div class="input-group">
                   <span class="input-group-addon"><b>From</b></span>
                     <input type="text" class="input-sm form-control from" id="date1" name="from1" />
                     <span class="input-group-addon"><b>To</b></span>
                     <input type="text" class="input-sm form-control to" id="date2" name="to1" />
                 </div>
                 </div>

               </div>

               <div class="Box1" style="display:none">
                 <p>  </p>
                 <div class="form-group">
                   <label>Reason</label>
                    <select class="form-control" name="reason" id="reason2">
                     <?php $reasons = DB::table('substitution_reason')->distinct()->get(['reason','id']); ?>
                     @foreach($reasons as $reason)
                            <option value='{{$reason->id}}'>{{$reason->reason}}</option>
                     @endforeach
                   </select>
                 </div>
                 <div class="form-group">
                     <label >Prescription:</label>
                     <select id="presc1" name="prescription" class="form-control presc1" style="width:50%"></select>
                 </div>

                 <p></p>
                 <p></p>
                 <p></p>
                 <p></p>


           <!-- <div class="form-group">
           <label>Strength Unit</label>

           <div class="radio radio-info radio-inline">
               <input type="radio" id="inlineRadio1" value="ml" name="strength_unit" class="req">
               <label for="inlineRadio1"> Ml</label>
           </div>
           <div class="radio radio-inline">
               <input type="radio" id="inlineRadio2" value="mg" name="strength_unit" class="req">
               <label for="inlineRadio2"> Mg </label>
           </div>
           </div> -->

          <!-- <div class="form-group">
           <label>Route</label>
            <select class="form-control" name="routes" id="route2">
              <?php //$routems=DB::table('route')->distinct()->get(['name','id','abbreviation']); ?>
              {{--  @foreach($routems as $routemz)
                  <option value="{{  $routemz->id }}">{{ $routemz->abbreviation }}----{{ $routemz->name  }} </option>
               @endforeach --}}
            </select>
         </div> -->

           <!-- <div class="form-group">
           <label>Frequency</label></td>
            <select class="form-control"  name="frequency" id="frequency2">
              <?php //$frequent=DB::table('frequency')->distinct()->get(['name','id','abbreviation']); ?>
              {{--   @foreach($frequent as $freq)
                  <option value="{{$freq->id }}">{{ $freq->abbreviation }}----{{ $freq->name  }} </option>
               @endforeach --}}
            </select>
         </div> -->

         <div class="form-group">
          <label>Weight</label>
           <select class="form-control" id="weight2" name="strength" required="">
             <option selected disabled>Select drug strength </option>
             <?php $Strengths=DB::table('strength')->distinct()->get(['strength']); ?>
               @foreach($Strengths as $Strengthz)
                 <option value="{{$Strengthz->strength}}">{{ $Strengthz->strength  }}  </option>
              @endforeach
          </select>
          </div>

         <!-- <div class="form-group"><label>Weight</label> <input type="number" id="weight2" name="weight2"  class="form-control" oninput="calc2()"></div> -->

         <div class="form-group"><label>Quantity</label> <input type="number" name="quantity1" id="quantity1" class="form-control" oninput="calc2();calculated();"></div>

         <div class="form-group"><label>Dose Given / Strength</label> <input type="number" name="dose_given2" id="sus"  class="form-control" oninput="calc2()" readonly></div>

         <div class="form-group"><label>Price</label> <input type="number" name="price1" id="price1" class="form-control" oninput="calculated()"></div>

         <div class="form-group">
           <label>Payment options</label>
            <select class="form-control" name="payment_options" id="pay_option" >
              <option value="" selected disabled>Select payment option</option>
             <?php $options = DB::table('payment_options')->distinct()
                          ->join('pharmacy_payment', 'pharmacy_payment.option_id', '=', 'payment_options.id')
                          ->where('pharmacy_payment.pharmacy_id', '=', $facility)
                          ->get(['payment_options.name','pharmacy_payment.markup']); ?>
             @foreach($options as $option)
                    <option value='{{$option->markup}}'>{{$option->name}}</option>
             @endforeach
           </select>
         </div>

         <div class="form-group"><label>Total</label> <input type="number" name="total1" id="total1" class="form-control" readonly oninput="calculated()"></div>

         <div class="form-group">
           <label class="font-normal">Prescription duration</label>
           <div class="input-group">
             <span class="input-group-addon"><b>From</b></span>
               <input type="text" class="input-sm form-control from" id="date3" name="from2" />
               <span class="input-group-addon"><b>To</b></span>
               <input type="text" class="input-sm form-control to" id="date4" name="to2" />
           </div>
           </div>

         </div>

         <script>
         $(document).ready(function() {
         //this calculates values automatically
         multiply();
         $("#weight1, #quantity").on("keydown keyup change", function() {
             multiply();
         });
        });

    function multiply() {
            //  var weight1 = document.getElementById('weight1').value;
            //  var quantity = document.getElementById('quantity').value;
 			     //   var result = parseInt(weight1) * parseInt(quantity);

           var weight1 = $("#weight1").val();
           var quantity = $("#quantity").val();
           var result = parseInt(weight1) * parseInt(quantity);

             if (!isNaN(result))
             {
                 $("#sub2").val(result);

             }
 			var strength = $("#strength22").val();

             if(result > strength)
             {
 				         $("#alert1").show();
                 $("#alert2").hide();

             $(function() {
                     jQuery.fn.extend({
                         disable: function(state) {
                             return this.each(function() {
                                 this.disabled = state;
                             });
                         }
                     });

                         $('#gg').disable(true);
                     });
                     }
                     else if(result < strength)
                     {
                          $("#alert2").show();
                          $("#alert1").hide();

                     $(function() {
                             jQuery.fn.extend({
                                 disable: function(state) {
                                     return this.each(function() {
                                         this.disabled = state;
                                     });
                                 }
                             });

                                 $('#gg').disable(true);
                             });
                             }
                     else
                     {
                       $("#alert1").hide();
                       $("#alert2").hide();

                      $(function() {
                         jQuery.fn.extend({
                           disable: function(state) {
                             return this.each(function() {
                             this.disabled = state;
                                 });
                                   }
                               });

                           $('#gg').disable(false);
                       });
                       }
         }
         </script>

         <!-- function for getting total during normal filling of prescription -->
         <script>
         $(document).ready(function() {
         //this calculates values automatically
         calculate();
         $("#price, #pay_option1, #quantity").on("keydown keyup change", function() {
             calculate();
         });
        });

         function calculate()
         {
          var price = parseFloat($('#price').val()) || 0;
          var pay = parseFloat($('#pay_option1').val()) || 0;
          var quantity = parseFloat($('#quantity').val()) || 0;

         $('#total').val(Math.round(quantity*price*pay));
          }
         </script>

         <!-- function for getting dose given during substitution -->
         <script>
         $(document).ready(function() {
         //this calculates values automatically
         calculated();
         $("#weight2, #quantity1").on("keydown keyup change", function() {
             calculated();
         });
        });

         function calculated()
         {
          var weight = parseFloat($('#weight2').val()) || 0;
          var quantity = parseFloat($('#quantity1').val()) || 0;

         $('#sus').val(Math.round(quantity*weight));
          };

         </script>

         <!-- function for getting total during substitution -->
         <script>
         $(document).ready(function() {
         //this calculates values automatically
         calculate2();
         $("#price1, #pay_option, #quantity1").on("keydown keyup change", function() {
             calculate2();
         });
        });

         function calculate2()
         {
          var price = parseFloat($('#price1').val()) || 0;
          var pay = parseFloat($('#pay_option').val()) || 0;
          var quantity = parseFloat($('#quantity1').val()) || 0;

         $('#total1').val(Math.round(quantity*price*pay));
          };
         </script>

         <!-- function for making prescription start and end date required during normal filling -->
         <script>
         $('#yeah').change(function ()
         {
           if($(this).is(':checked'))
           {
             $('#weight1').attr('required', true);
             $('#quantity').attr('required', true);
             $('#rrp1').attr('required', true);
             $('#price').attr('required', true);
             $('#pay_option1').attr('required', true);
             $('#date1').attr('required', true);
             $('#date2').attr('required', true);
           }
           else
           {
             $('#weight1').removeAttr('required');
             $('#quantity').removeAttr('required');
             $('#rrp1').removeAttr('required');
             $('#price').removeAttr('required');
             $('#pay_option1').removeAttr('required');
             $('#date1').removeAttr('required');
             $('#date2').removeAttr('required');
           }
         });
         </script>

         <!-- function for making prescription start and end date required during substitution -->
         <script>
         $('#nah').change(function()
         {
           if($(this).is(':checked'))
           {
             $('#reason2').attr('required', true);
             $('#presc2').attr('required', true);
             $('#route2').attr('required', true);
             $('#frequency2').attr('required', true);
             $('#weight2').attr('required', true);
             $('#quantity1').attr('required', true);
             $('#price1').attr('required', true);
             $('#pay_option').attr('required', true);
             $('.req').attr('required', true);
             $('#date3').attr('required', true);
             $('#date4').attr('required', true);
           }
           else
           {
             $('#reason2').removeAttr('required');
             $('#presc2').removeAttr('required');
             $('#route2').removeAttr('required');
             $('#frequency2').removeAttr('required');
             $('#weight2').removeAttr('required');
             $('#quantity1').removeAttr('required');
             $('#price1').removeAttr('required');
             $('#pay_option').removeAttr('required');
             $('.req').removeAttr('required');
             $('#date3').removeAttr('required');
             $('#date4').removeAttr('required');
           }
         });
         </script>


         <p> </p>
         <p> </p>
         <p> </p>
         <div class="form-group">
           <div >
           <button class="btn btn-w-m btn-primary" id="gg" type="submit">Submit</button>
           </div>
         </div>

           {{ Form::close() }}

                   </div>
                 </div>
                   </div>
         <a href="{{route('pharmacy.show',$results->the_id)}}"><button type="button" class="btn btn-w-m btn-primary">Back</button></a>


               </div>

@endsection
