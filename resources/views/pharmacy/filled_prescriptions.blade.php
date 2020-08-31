@extends('layouts.pharmacy')
@section('title', 'Pharmacy')
@section('content')


               <!-- Begin Sales Summary -->

               <div class="tabs-container">
                 <!-- <div class="col-lg-12 tbg"> -->
                   <ul class="nav nav-tabs">
                       <li class="active"><a data-toggle="tab" href="#tab-1">Today</a></li>
                       <li class=""><a data-toggle="tab" href="#tab-2">This Week</a></li>
                       <li class=""><a data-toggle="tab" href="#tab-3">This Month</a></li>
                       <li class=""><a data-toggle="tab" href="#tab-4">This Year</a></li>
                       <li class=""><a data-toggle="tab" href="#tab-5">All</a></li>
                   </ul>
                   <br>
             <div class="tab-content">
               <!-- Today's Sale -->
           <div id="tab-1" class="tab-pane active">
               <div class="row">
                   <div class="col-lg-11">
                   <div class="ibox float-e-margins">
                       <div class="ibox-title">
                           <h5>Sales Summary </h5>

                       </div>
                       <div class="ibox-content">

                     <div class="table-responsive">
                       <table class="table table-striped table-bordered table-hover dataTables-example" >
                       <thead>
                           <tr>
                             <th>No</th>
                             <th>Manufacturer</th>
                             <th>Drug</th>
                             <th>Date of Prescription</th>
                             <th>Prescribing Doctor</th>
                             <th>Dose</th>
                             <th>Quantity</th>
                             <th>Total</th>
                         </tr>
                       </thead>
                       <tbody>
                       <?php $i = 1;

                       foreach($todays as $today)
                       {
                         $date = strtotime($today->prescription_date);
                         $date  = date('Y-m-d',$date);

                         $doc = '';

                         if(isset($today->doc))
                         {
                          $doc = $today->doc;
                         }
                         elseif(isset($today->prescribing_doctor))
                         {
                           $doc = DB::table('prescriptions')
                                ->leftJoin('doctors', 'doctors.id', '=', 'prescriptions.prescribing_doctor')
                                ->select('doctors.name AS doc_name')
                                ->where('prescriptions.id', '=', $today->presc_id)
                                ->first();
                            $doc = $doc->doc_name;
                         }
                         elseif(isset($today->prescribing_pharmacist))
                         {
                           $pharmacist = DB::table('pharmacists')
                                      ->select('name')
                                      ->where('user_id', '=', $today->prescribing_pharmacist)
                                      ->first();
                            $doc = $pharmacist->name.'--- Pharmacist';
                         }
                       ?>
                          <tr>
                            <td><a href="{{route('pharmacy_receipts',$today->pdetails_id) }}" target="_blank">{{$i}}</a></td>
                            @if($today->available == 'Yes')
                            <td><a href="{{route('pharmacy_receipts',$today->pdetails_id) }}" target="_blank">{{$today->Manufacturer}}</a></td>
                            <td>{{$today->drugname}}</td>
                            @elseif($today->available == 'No')
                            <?php
                            $manu = DB::table('druglists')
                                         ->select('Manufacturer')
                                         ->where('id', '=', $today->drug2)
                                         ->first();
                             ?>
                            <td><a href="{{route('pharmacy_receipts',$today->pdetails_id) }}" target="_blank">{{$manu->Manufacturer}}</a></td>
                            <td>{{$today->inv_drug}}</td>
                            @endif
                            <td>{{$date}}</td>
                            <td>{{$doc}}</td>
                            <td>{{$today->dose_given.' '.$today->strength_unit}}</td>
                            <td>{{$today->quantity}}</td>
                            <td>{{$today->total}}</td>
                          </tr>
                         <?php
                         $i++;
                        }
                         ?>
                        </tbody>
                      </table>
                          </div>

                      </div>
                  </div>
              </div>
              </div>
              </div>

              <!-- Current Week Sale -->
              <div id="tab-2" class="tab-pane">
               <div class="row">
                   <div class="col-lg-11">
                   <div class="ibox float-e-margins">
                     <div class="ibox-title">
                         <h5>Sales Summary</h5>
                     </div>

                       <div class="ibox-content">

                           <div class="table-responsive">
                       <table class="table table-striped table-bordered table-hover dataTables-example" >
                       <thead>
                           <tr>
                             <th>No</th>
                             <th>Manufacturer</th>
                             <th>Drug</th>
                             <th>Date of Prescription</th>
                             <th>Prescribing Doctor</th>
                             <th>Dose</th>
                             <th>Quantity</th>
                             <th>Total</th>

                         </tr>
                       </thead>

                       <tbody>
                         <?php $i = 1;

                         foreach($weeks as $week)
                         {
                           $date = strtotime($week->prescription_date);
                           $date = date('Y-m-d',$date);
                           $doc = '';

                           if(isset($week->doc))
                           {
                            $doc = $week->doc;
                           }
                           elseif(isset($week->prescribing_doctor))
                           {
                             $doc = DB::table('prescriptions')
                                  ->leftJoin('doctors', 'doctors.id', '=', 'prescriptions.prescribing_doctor')
                                  ->select('doctors.name AS doc_name')
                                  ->where('prescriptions.id', '=', $week->presc_id)
                                  ->first();
                              $doc = $doc->doc_name;
                           }
                           elseif(isset($week->prescribing_pharmacist))
                           {
                             $pharmacist = DB::table('pharmacists')
                                        ->select('name')
                                        ->where('user_id', '=', $week->prescribing_pharmacist)
                                        ->first();
                              $doc = $pharmacist->name.'--- Pharmacist';
                           }
                         ?>
                            <tr>
                              <td><a href="{{route('pharmacy_receipts',$week->pdetails_id) }}" target="_blank">{{$i}}</a></td>
                              @if($week->available == 'Yes')
                              <td><a href="{{route('pharmacy_receipts',$week->pdetails_id) }}" target="_blank">{{$week->Manufacturer}}</a></td>
                              <td>{{$week->drugname}}</td>
                              @elseif($week->available == 'No')
                              <?php
                              $manu = DB::table('druglists')
                                           ->select('Manufacturer')
                                           ->where('id', '=', $week->drug2)
                                           ->first();
                               ?>
                              <td><a href="{{route('pharmacy_receipts',$week->pdetails_id) }}" target="_blank">{{$manu->Manufacturer}}</a></td>
                              <td>{{$week->inv_drug}}</td>
                              @endif
                               ?>
                              <td>{{$date}}</td>
                              <td>{{$doc}}</td>
                              <td>{{$week->dose_given.' '.$week->strength_unit}}</td>
                              <td>{{$week->quantity}}</td>
                              <td>{{$week->total}}</td>
                            </tr>
                           <?php
                           $i++;
                          }
                           ?>
                        </tbody>
                      </table>
                          </div>

                      </div>
                  </div>
              </div>
              </div>
              </div>

              <!-- Current Month Sale -->
              <div id="tab-3" class="tab-pane">
               <div class="row">
                   <div class="col-lg-11">
                   <div class="ibox float-e-margins">
                       <div class="ibox-title">
                           <h5>Sales Summary</h5>
                       </div>
                       <div class="ibox-content">

                           <div class="table-responsive">
                       <table class="table table-striped table-bordered table-hover dataTables-example" >
                       <thead>
                           <tr>
                             <th>No</th>
                             <th>Manufacturer</th>
                             <th>Drug</th>
                             <th>Date of Prescription</th>
                             <th>Prescribing Doctor</th>
                             <th>Dose</th>
                             <th>Quantity</th>
                             <th>Total</th>

                         </tr>
                       </thead>

                       <tbody>
                         <?php $i = 1;

                         foreach($months as $month)
                         {
                           $date = strtotime($month->prescription_date);
                           $date = date('Y-m-d',$date);
                           $doc = '';

                           if(isset($month->doc))
                           {
                            $doc = $month->doc;
                           }
                           elseif(isset($month->prescribing_doctor))
                           {
                             $doc = DB::table('prescriptions')
                                  ->leftJoin('doctors', 'doctors.id', '=', 'prescriptions.prescribing_doctor')
                                  ->select('doctors.name AS doc_name')
                                  ->where('prescriptions.id', '=', $month->presc_id)
                                  ->first();
                              $doc = $doc->doc_name;
                           }
                           elseif(isset($month->prescribing_pharmacist))
                           {
                             $pharmacist = DB::table('pharmacists')
                                        ->select('name')
                                        ->where('user_id', '=', $month->prescribing_pharmacist)
                                        ->first();
                              $doc = $pharmacist->name.'--- Pharmacist';
                           }
                         ?>
                            <tr>
                              <td><a href="{{route('pharmacy_receipts',$month->pdetails_id) }}" target="_blank">{{$i}}</a></td>
                              @if($month->available == 'Yes')
                              <td><a href="{{route('pharmacy_receipts',$month->pdetails_id) }}" target="_blank">{{$month->Manufacturer}}</a></td>
                              <td>{{$month->drugname}}</td>
                              @elseif($month->available == 'No')
                              <?php
                              $manu = DB::table('druglists')
                                           ->select('Manufacturer')
                                           ->where('id', '=', $month->drug2)
                                           ->first();
                               ?>
                              <td><a href="{{route('pharmacy_receipts',$month->pdetails_id) }}" target="_blank">{{$manu->Manufacturer}}</a></td>
                              <td>{{$month->inv_drug}}</td>
                              @endif
                              <td>{{$date}}</td>
                              <td>{{$doc}}</td>
                              <td>{{$month->dose_given.' '.$month->strength_unit}}</td>
                              <td>{{$month->quantity}}</td>
                              <td>{{$month->total}}</td>
                            </tr>
                           <?php
                           $i++;
                          }
                           ?>
                        </tbody>
                      </table>
                          </div>

                      </div>
                  </div>
              </div>
              </div>
              </div>

              <!-- Current Year sales -->
              <div id="tab-4" class="tab-pane">
               <div class="row">
                   <div class="col-lg-11">
                   <div class="ibox float-e-margins">
                       <div class="ibox-title">
                           <h5>Sales Summary</h5>

                       </div>
                       <div class="ibox-content">

                           <div class="table-responsive">
                       <table class="table table-striped table-bordered table-hover dataTables-example" >
                       <thead>
                           <tr>
                             <th>No</th>
                             <th>Manufacturer</th>
                             <th>Drug</th>
                             <th>Date of Prescription</th>
                             <th>Prescribing Doctor</th>
                             <th>Dose</th>
                             <th>Quantity</th>
                             <th>Total</th>

                         </tr>
                       </thead>

                       <tbody>
                         <?php $i = 1;

                         foreach($years as $year)
                         {
                           $date = strtotime($year->prescription_date);
                           $date = date('Y-m-d',$date);
                           $doc = '';

                           if(isset($year->doc))
                           {
                            $doc = $year->doc;
                           }
                           elseif(isset($year->prescribing_doctor))
                           {
                             $doc = DB::table('prescriptions')
                                  ->leftJoin('doctors', 'doctors.id', '=', 'prescriptions.prescribing_doctor')
                                  ->select('doctors.name AS doc_name')
                                  ->where('prescriptions.id', '=', $year->presc_id)
                                  ->first();
                              $doc = $doc->doc_name;
                           }
                           elseif(isset($year->prescribing_pharmacist))
                           {
                             $pharmacist = DB::table('pharmacists')
                                        ->select('name')
                                        ->where('user_id', '=', $year->prescribing_pharmacist)
                                        ->first();
                              $doc = $pharmacist->name.'--- Pharmacist';
                           }
                         ?>
                            <tr>
                              <td><a href="{{route('pharmacy_receipts',$year->pdetails_id) }}" target="_blank">{{$i}}</a></td>
                              @if($year->available == 'Yes')
                              <td><a href="{{route('pharmacy_receipts',$year->pdetails_id) }}" target="_blank">{{$year->Manufacturer}}</a></td>
                              <td>{{$year->drugname}}</td>
                              @elseif($year->available == 'No')
                              <?php
                              $manu = DB::table('druglists')
                                           ->select('Manufacturer')
                                           ->where('id', '=', $year->drug2)
                                           ->first();
                               ?>
                              <td><a href="{{route('pharmacy_receipts',$year->pdetails_id) }}" target="_blank">{{$manu->Manufacturer}}</a></td>
                              <td>{{$year->inv_drug}}</td>
                              @endif
                              <td>{{$date}}</td>
                              <td>{{$doc}}</td>
                              <td>{{$year->dose_given.' '.$year->strength_unit}}</td>
                              <td>{{$year->quantity}}</td>
                              <td>{{$year->total}}</td>
                            </tr>
                           <?php
                           $i++;
                          }
                           ?>
                        </tbody>
                      </table>
                          </div>

                      </div>
                  </div>
              </div>
              </div>
              </div>

              <!-- All Sales -->
              <div id="tab-5" class="tab-pane">
               <div class="row">
                   <div class="col-lg-11">
                   <div class="ibox float-e-margins">
                     <div class="ibox-title">
                         <h5>Sales Summary</h5>
                     </div>

                       <div class="ibox-content">

                      <div class="table-responsive">
                       <table class="table table-striped table-bordered table-hover dataTables-example" >
                       <thead>
                           <tr>
                             <th>No</th>
                             <th>Manufacturer</th>
                             <th>Drug</th>
                             <th>Date of Prescription</th>
                             <th>Prescribing Doctor</th>
                             <th>Dose</th>
                             <th>Quantity</th>
                             <th>Total</th>

                         </tr>
                       </thead>

                       <tbody>
                         <?php $i =1;

                         foreach($prescs as $presc)
                         {

                           $presc_date = $presc->prescription_date;
                           $my_date = strtotime($presc_date);
                           $presc_date = date("Y-m-d",$my_date);
                           $manufacturer = $presc->Manufacturer;
                           $doc = '';

                           if(isset($presc->doc))
                           {
                            $doc = $presc->doc;
                           }
                           elseif(isset($presc->prescribing_doctor))
                           {
                             $doc = DB::table('prescriptions')
                                  ->leftJoin('doctors', 'doctors.id', '=', 'prescriptions.prescribing_doctor')
                                  ->select('doctors.name AS doc_name')
                                  ->where('prescriptions.id', '=', $presc->presc_id)
                                  ->first();
                              $doc = $doc->doc_name;
                           }
                           elseif(isset($presc->prescribing_pharmacist))
                           {
                             $pharmacist = DB::table('pharmacists')
                                        ->select('name')
                                        ->where('user_id', '=', $presc->prescribing_pharmacist)
                                        ->first();
                              $doc = $pharmacist->name.'--- Pharmacist';
                           }

                           $dose = $presc->dose_given.' '.$presc->strength_unit;

                           $quantity = $presc->quantity;
                           $price = $presc->price;
                           $totals = $presc->total;

                       ?>
                           <tr>
                               <td><a href="{{route('pharmacy_receipts',$presc->pdetails_id) }}" target="_blank">{{$i}}</a></td>
                               @if($presc->available == 'Yes')
                               <td><a href="{{route('pharmacy_receipts',$presc->pdetails_id) }}" target="_blank">{{$manufacturer}}</a></td>
                               <td>{{$presc->drugname}}</td>
                               @elseif($presc->available == 'No')
                               <?php
                               $manu = DB::table('druglists')
                                            ->select('Manufacturer')
                                            ->where('id', '=', $presc->drug2)
                                            ->first();
                                ?>
                               <td><a href="{{route('pharmacy_receipts',$presc->pdetails_id) }}" target="_blank">{{$manu->Manufacturer}}</a></td>
                               <td>{{$presc->inv_drug}}</td>
                               @endif

                               <td>{{$presc_date}}</td>
                               <td>{{$doc}}</td>
                               <td>{{$dose}}</td>
                               <td>{{$quantity}}</td>
                               <td>{{$totals}}</td>

                           </tr>
                           <?php $i++;
                           }
                            ?>

                        </tbody>
                      </table>
                          </div>

                      </div>
                  </div>
              </div>
              </div>
              </div>



              </div>
          </div>

@endsection
