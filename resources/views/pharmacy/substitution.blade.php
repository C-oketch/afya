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
                   <th>Dosage Prescribed</th>
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
            $su = $query2->strength_unit;
            $final = $count2 - $count1;
             ?>

           <div class="form-group"><label>Drug</label> <input type="text" name="drug" value="{{$results->drugname}}"  class="form-control" readonly></div>
           <div class="form-group"><label>Strength</label> <input type="text" id="strength22" value="{{$final.$su}}"  class="form-control" readonly></div>

                 <div class="form-group">
                   <label>Reason</label>
                    <select class="form-control" name="reason" required="">
                      <option value="" selected disabled>Select reason</option>
                     <?php $reasons = DB::table('substitution_reason')->distinct()->get(['reason','id']); ?>
                     @foreach($reasons as $reason)
                            <option value='{{$reason->id}}'>{{$reason->reason}}</option>
                     @endforeach
                   </select>

                 </div>
                 <div class="form-group">
                     <label >Prescription:</label>
                     <select id="presc1" name="prescription" class="form-control presc1" style="width:50%" required=""></select>
                 </div>

                 <p></p>
                 <p></p>
                 <p></p>
                 <p></p>


           <!-- <div class="form-group">
           <label>Strength Unit</label>

           <div class="radio radio-info radio-inline">
               <input type="radio" id="inlineRadio1" value="ml" name="strength_unit" required="">
               <label for="inlineRadio1"> Ml</label>
           </div>
           <div class="radio radio-inline">
               <input type="radio" id="inlineRadio2" value="mg" name="strength_unit" required="">
               <label for="inlineRadio2"> Mg </label>
           </div>
           </div> -->

          <!-- <div class="form-group">
           <label>Route</label>
            <select class="form-control" name="routes" required="">
              <option value="" selected disabled>Select route</option>
              <?php //$routems=DB::table('route')->distinct()->get(['name','id','abbreviation']); ?>
              {{--  @foreach($routems as $routemz)
                  <option value="{{$routemz->id }}">{{ $routemz->abbreviation }}----{{ $routemz->name  }} </option>
               @endforeach --}}
            </select>
         </div> -->

           <!-- <div class="form-group">
           <label>Frequency</label></td>
            <select class="form-control"  name="frequency" required="">
              <option value="" selected disabled>Select frequency</option>
              <?php $frequent=DB::table('frequency')->distinct()->get(['name','id','abbreviation']); ?>
              {{--  @foreach($frequent as $freq)
                  <option value="{{$freq->id }}">{{ $freq->abbreviation }}----{{ $freq->name  }} </option>
               @endforeach --}}
            </select>
         </div> -->

         <div class="form-group">
          <label>Weight</label>
           <select class="form-control" id="weight2" name="weight2" required="">
             <option selected disabled>Select drug strength </option>
             <?php $Strengths=DB::table('strength')->distinct()->get(['strength']); ?>
               @foreach($Strengths as $Strengthz)
                 <option value="{{$Strengthz->strength}}">{{ $Strengthz->strength  }}  </option>
              @endforeach
          </select>
          </div>


         <div class="form-group"><label>Quantity</label> <input type="number" name="quantity1" id="quantity1" class="form-control" required="" ></div>

         <div class="form-group"><label>Dose Given</label> <input type="number" name="dose_given2" id="sus"  class="form-control" readonly></div>

         <div class="form-group"><label>Price</label> <input type="number" name="price1" id="price1" class="form-control" required=""></div>

         <div class="form-group">
           <label>Payment options</label>
            <select class="form-control" name="payment_options" id="pay_option" required="">
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

         <div class="form-group"><label>Total</label> <input type="text" name="total1" id="total1" class="form-control" readonly ></div>

         <div class="form-group">
         <label for="from">From</label>
         <input class="from"  type="text"  name="from2" required="">
         <label for="to">To</label>
         <input class="to" type="text" name="to2" required="">
         </div>


         <!-- function for getting dose given during substitution -->
         <script>
         $(document).ready(function() {
         //this calculates values automatically
         calculate2();
         $("#weight2, #quantity1").on("keydown keyup change", function() {
             calculate2();
         });
        });

         function calculate2()
         {
          var weight = parseFloat($('#weight2').val()) || 0;
          var quantity = parseFloat($('#quantity1').val()) || 0;

         $('#sus').val(Math.round(quantity*weight));
          };

         </script>


         <!-- function for getting total during substitution -->
         <script>
         $(document).ready(function() {
         calculate1();
         $("#price1, #pay_option, #quantity1").on("keydown keyup change", function() {
           calculate1();

         });
        });

        function calculate1()
        {
          var price = parseFloat($('#price1').val()) || 0;
          var pay = parseFloat($('#pay_option').val()) || 0;
          var quantity = parseFloat($('#quantity1').val()) || 0;

          $('#total1').val(Math.round(quantity*price*pay));
        }

         </script>


         <p> </p>
         <p> </p>
         <p> </p>
         <div class="form-group">
           <div >
           <button class="btn btn-w-m btn-primary" type="submit">Submit</button>
           </div>
         </div>

           {{ Form::close() }}

                   </div>
                 </div>
                   </div>
         <a href="{{route('pharmacy.show',$results->the_id)}}"><button type="button" class="btn btn-w-m btn-primary">Back</button></a>


               </div>

@endsection
