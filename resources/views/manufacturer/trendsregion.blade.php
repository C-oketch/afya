<div id="tab-3" class="tab-pane">
<h1 style="text-align:center">
<ul class="nav nav-tabs">
 <li class="active"><a data-toggle="tab" href="#tab-31a">Today</a></li>
 <li class=""><a data-toggle="tab" href="#tab-32a">This Week</a></li>
 <li class=""><a data-toggle="tab" href="#tab-33a">This Month</a></li>
 <li class=""><a data-toggle="tab" href="#tab-34a">This Year</a></li>
 <li class=""><a data-toggle="tab" href="#tab-35a">Custom</a></li>
</ul>
</h1>

<div class="tab-content">
 <div id="tab-31a" class="tab-pane active">
   <div class="col-lg-12">
     <div class="ibox float-e-margins">
         <div class="ibox-title">
             <h3>Gainers</h3>
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
 <table class="table borderless dataTables-example">
                 <thead>
                 <tr>
                     <th>No</th>
                     <th>Drug Name</th>
                     <th>Change</th>
                     <th>Total Sales</th>
                 </tr>
                 </thead>
                 <tbody>
                 <?php
                 use Carbon\Carbon;
                 $today = Carbon::today();

                 $yesterday = Carbon::today()->subDays(1);
                 $previous = Carbon::today()->subDays(2);
                 $one_week_ago = Carbon::now()->subWeeks(1);
                 $two_week_ago = Carbon::now()->subWeeks(2);
                 $one_month_ago = Carbon::now()->subMonths(1);
                 $two_month_ago = Carbon::now()->subMonths(2);
                 $one_year_ago = Carbon::now()->subYears(1);
                 $two_year_ago = Carbon::now()->subYears(2);

                  $RTrendsale = DB::table('prescription_filled_status')
                      ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                      ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                      ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                        ->groupBy('county')
                        ->whereNull('prescription_filled_status.substitute_presc_id')
                        ->where([ ['prescription_filled_status.created_at','<',$today],
                                  ['prescription_filled_status.created_at','>=',$yesterday],
                                 ])
                         ->orderBy('totalq', 'desc')
                         ->LIMIT(10)
                          ->get();
                          $i=1;
                       ?>

                 @foreach($RTrendsale as $trend)

                 <?php  $RTrendsold = DB::table('prescription_filled_status')
                 ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                 ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                 ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                   ->groupBy('county')
                   ->whereNull('prescription_filled_status.substitute_presc_id')
                   ->where([ ['prescription_filled_status.created_at','<',$yesterday],
                             ['prescription_filled_status.created_at','>=',$previous],
                              ])
                    ->orderBy('totalq', 'desc')
                     ->first();
                 ?>
                 <?php    if($RTrendsold && ($trend->totalq > $RTrendsold->totalq))  { ?>
                 <tr>
                 <td>{{$i}}</td>
                 <td>{{$trend->county}}</td>
                 <td class="text-navy"> <i class="fa fa-level-up"></i><?php echo (round((($trend->totalq - $RTrendsold->totalq)/$trend->totalq)*100,2)).'%' ;?></td>
                 <td>{{$trend->totalq}}</td>
                 </tr>
                   <?php  $i++  ?>
                 <?php   } ?>
                 @endforeach
                 <tr><td><h3>Losers</h3></td></tr>
                 <?php   $RTrendsaleL = DB::table('prescription_filled_status')
                   ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                   ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                   ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                     ->groupBy('county')
                     ->whereNull('prescription_filled_status.substitute_presc_id')
                     ->where([ ['prescription_filled_status.created_at','<',$today],
                               ['prescription_filled_status.created_at','>=',$yesterday],
                              ])
                      ->orderBy('totalq', 'desc')
                      ->LIMIT(10)
                       ->get();
                       $i=1;
                    ?>

                 @foreach($RTrendsaleL as $trendL)

                 <?php  $RTrendsoldL = DB::table('prescription_filled_status')
                 ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                 ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                 ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                 ->groupBy('county')
                 ->whereNull('prescription_filled_status.substitute_presc_id')
                 ->where([ ['prescription_filled_status.created_at','<',$yesterday],
                          ['prescription_filled_status.created_at','>=',$previous],
                          ['pharmacy.county','like','%'.$trendL->county.'%'],

                         ])
                 ->orderBy('totalq', 'desc')
                  ->first();
                 ?>
                 <?php    if($RTrendsoldL && ($trendL->totalq < $RTrendsoldL->totalq))  { ?>
                 <tr>
                 <td>{{$i}}</td>
                 <td>{{$trendL->county}}</td>
                 <td class="text-danger"><i class="fa fa-level-down"></i><?php echo (round((($trendL->totalq - $RTrendsoldL->totalq)/$trendL->totalq)*100,2)).'%' ;?></td>
                 <td>{{$trendL->totalq}}</td>
                 </tr>
                 <?php  $i++  ?>
                 <?php   } ?>
                 @endforeach
                 </tbody>
             </table>

         </div>
     </div>
 </div>
</div>


<!--................................. THIS WEEK ...........................-->
<div id="tab-32a" class="tab-pane">
 <div class="col-lg-12">
   <div class="ibox float-e-margins">
       <div class="ibox-title">
           <h3>Gainers</h3>
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
<table class="table borderless dataTables-example">
               <thead>
               <tr>
                   <th>No</th>
                   <th>Drug Name</th>
                   <th>Change</th>
                   <th>Total Sales</th>
               </tr>
               </thead>
               <tbody>
               <?php
             $RTrendsalew = DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                    ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                    ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                      ->groupBy('county')
                      ->whereNull('prescription_filled_status.substitute_presc_id')
                      ->where([ ['prescription_filled_status.created_at','<',$today],
                                ['prescription_filled_status.created_at','>=',$one_week_ago],
                               ])
                       ->orderBy('totalq', 'desc')
                       ->LIMIT(10)
                        ->get();
                        $i=1;
                     ?>

           @foreach($RTrendsalew as $trend)

       <?php  $RTrendsoldw = DB::table('prescription_filled_status')
               ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
               ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
               ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                 ->groupBy('county')
                 ->whereNull('prescription_filled_status.substitute_presc_id')
                 ->where([ ['prescription_filled_status.created_at','<',$one_week_ago],
                           ['prescription_filled_status.created_at','>=',$two_week_ago],


                          ])
                  ->orderBy('totalq', 'desc')
                   ->first();
           ?>
     <?php    if($RTrendsoldw && ($trend->totalq > $RTrendsoldw->totalq))  { ?>
             <tr>
               <td>{{$i}}</td>
               <td>{{$trend->county}}</td>
               <td class="text-navy"> <i class="fa fa-level-up"></i><?php echo (round((($trend->totalq - $RTrendsoldw->totalq)/$trend->totalq)*100,2)).'%' ;?></td>
               <td>{{$trend->totalq}}</td>
               </tr>
                 <?php  $i++  ?>
             <?php   } ?>
             @endforeach
            <tr><td><h3>Losers</h3></td></tr>
           <?php   $RTrendsalewL = DB::table('prescription_filled_status')
                 ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                 ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                 ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                   ->groupBy('county')
                   ->whereNull('prescription_filled_status.substitute_presc_id')
                   ->where([ ['prescription_filled_status.created_at','<',$today],
                             ['prescription_filled_status.created_at','>=',$one_week_ago],
                            ])
                    ->orderBy('totalq', 'desc')
                    ->LIMIT(10)
                     ->get();
                     $i=1;
                  ?>

             @foreach($RTrendsalewL as $trendL)

             <?php  $RTrendsoldwL = DB::table('prescription_filled_status')
             ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
             ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
             ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
              ->groupBy('county')
              ->whereNull('prescription_filled_status.substitute_presc_id')
              ->where([ ['prescription_filled_status.created_at','<',$one_week_ago],
                        ['prescription_filled_status.created_at','>=',$two_week_ago],
                        ['pharmacy.county','like','%'.$trendL->county.'%'],

                       ])
               ->orderBy('totalq', 'desc')
                ->first();
             ?>
             <?php    if($RTrendsoldwL && ($trendL->totalq < $RTrendsoldwL->totalq))  { ?>
             <tr>
             <td>{{$i}}</td>
             <td>{{$trendL->county}}</td>
             <td class="text-danger"><i class="fa fa-level-down"></i><?php echo (round((($trendL->totalq - $RTrendsoldwL->totalq)/$trendL->totalq)*100,2)).'%' ;?></td>
             <td>{{$trendL->totalq}}</td>
             </tr>
              <?php  $i++  ?>
             <?php   } ?>
             @endforeach
               </tbody>
           </table>

       </div>
   </div>
</div>
</div>



<!--................................. THIS MONTH...........................-->

<div id="tab-33a" class="tab-pane">
 <div class="col-lg-12">
   <div class="ibox float-e-margins">
       <div class="ibox-title">
           <h3>Gainers</h3>
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
<table class="table borderless dataTables-example">
               <thead>
               <tr>
                   <th>No</th>
                   <th>Drug Name</th>
                   <th>Change</th>
                   <th>Total Sales</th>
               </tr>
               </thead>
               <tbody>
               <?php
             $RTrendsalem = DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                    ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                    ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                      ->groupBy('county')
                      ->whereNull('prescription_filled_status.substitute_presc_id')
                      ->where([ ['prescription_filled_status.created_at','<',$today],
                                ['prescription_filled_status.created_at','>=',$one_month_ago],
                               ])
                       ->orderBy('totalq', 'desc')
                       ->LIMIT(10)
                        ->get();
                        $i=1;
                     ?>

           @foreach($RTrendsalem as $trend)

       <?php  $RTrendsoldm = DB::table('prescription_filled_status')
               ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
               ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
               ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                 ->groupBy('county')
                 ->whereNull('prescription_filled_status.substitute_presc_id')
                 ->where([ ['prescription_filled_status.created_at','<',$one_month_ago],
                           ['prescription_filled_status.created_at','>=',$two_month_ago],


                          ])
                  ->orderBy('totalq', 'desc')
                   ->first();
           ?>
     <?php    if($RTrendsoldm && ($trend->totalq > $RTrendsoldm->totalq))  { ?>
             <tr>
               <td>{{$i}}</td>
               <td>{{$trend->county}}</td>
               <td class="text-navy"> <i class="fa fa-level-up"></i><?php echo (round((($trend->totalq - $RTrendsoldm->totalq)/$trend->totalq)*100,2)).'%' ;?></td>
               <td>{{$trend->totalq}}</td>
               </tr>
                 <?php  $i++  ?>
             <?php   } ?>
             @endforeach
            <tr><td><h3>Losers</h3></td></tr>
           <?php   $RTrendsalemL = DB::table('prescription_filled_status')
                 ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                 ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                 ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                   ->groupBy('county')
                   ->whereNull('prescription_filled_status.substitute_presc_id')
                   ->where([ ['prescription_filled_status.created_at','<',$today],
                             ['prescription_filled_status.created_at','>=',$one_month_ago],
                            ])
                    ->orderBy('totalq', 'desc')
                    ->LIMIT(10)
                     ->get();
                     $i=1;
                  ?>

             @foreach($RTrendsalemL as $trendL)

             <?php  $RTrendsoldmL = DB::table('prescription_filled_status')
             ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
             ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
             ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
              ->groupBy('county')
              ->whereNull('prescription_filled_status.substitute_presc_id')
              ->where([ ['prescription_filled_status.created_at','<',$one_month_ago],
                        ['prescription_filled_status.created_at','>=',$two_month_ago],
                        ['pharmacy.county','like','%'.$trendL->county.'%'],

                       ])
               ->orderBy('totalq', 'desc')
                ->first();
             ?>
             <?php    if($RTrendsoldmL && ($trendL->totalq < $RTrendsoldmL->totalq))  { ?>
             <tr>
             <td>{{$i}}</td>
             <td>{{$trendL->county}}</td>
             <td class="text-danger"><i class="fa fa-level-down"></i><?php echo (round((($trendL->totalq - $RTrendsoldmL->totalq)/$trendL->totalq)*100,2)).'%' ;?></td>
             <td>{{$trendL->totalq}}</td>
             </tr>
              <?php  $i++  ?>
             <?php   } ?>
             @endforeach
               </tbody>
           </table>

       </div>
   </div>
</div>
</div>

<!--................................. THIS YEAR ...........................-->
<div id="tab-34a" class="tab-pane">
<div class="col-lg-12">
 <div class="ibox float-e-margins">
     <div class="ibox-title">
         <h3>Gainers</h3>
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
<table class="table borderless dataTables-example">
             <thead>
             <tr>
                 <th>No</th>
                 <th>Drug Name</th>
                 <th>Change</th>
                 <th>Total Sales</th>
             </tr>
             </thead>
             <tbody>
             <?php
           $RTrendsaley = DB::table('prescription_filled_status')
                  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                  ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                    ->groupBy('county')
                    ->whereNull('prescription_filled_status.substitute_presc_id')
                    ->where([ ['prescription_filled_status.created_at','<',$today],
                              ['prescription_filled_status.created_at','>=',$one_year_ago],
                             ])
                     ->orderBy('totalq', 'desc')
                     ->LIMIT(10)
                      ->get();
                      $i=1;
                   ?>

         @foreach($RTrendsaley as $trend)

     <?php  $RTrendsoldy = DB::table('prescription_filled_status')
             ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
             ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
             ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
               ->groupBy('county')
               ->whereNull('prescription_filled_status.substitute_presc_id')
               ->where([ ['prescription_filled_status.created_at','<',$one_year_ago],
                         ['prescription_filled_status.created_at','>=',$two_year_ago],


                        ])
                ->orderBy('totalq', 'desc')
                 ->first();
         ?>
   <?php    if($RTrendsoldy && ($trend->totalq > $RTrendsoldy->totalq))  { ?>
           <tr>
             <td>{{$i}}</td>
             <td>{{$trend->county}}</td>
             <td class="text-navy"> <i class="fa fa-level-up"></i><?php echo (round((($trend->totalq - $RTrendsoldy->totalq)/$trend->totalq)*100,2)).'%' ;?></td>
             <td>{{$trend->totalq}}</td>
             </tr>
               <?php  $i++  ?>
           <?php   } ?>
           @endforeach
          <tr><td><h3>Losers</h3></td></tr>
         <?php   $RTrendsaleyL = DB::table('prescription_filled_status')
               ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
               ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
               ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                 ->groupBy('county')
                 ->whereNull('prescription_filled_status.substitute_presc_id')
                 ->where([ ['prescription_filled_status.created_at','<',$today],
                           ['prescription_filled_status.created_at','>=',$one_year_ago],
                          ])
                  ->orderBy('totalq', 'desc')
                  ->LIMIT(10)
                   ->get();
                   $i=1;
                ?>

           @foreach($RTrendsaleyL as $trendL)

           <?php  $RTrendsoldyL = DB::table('prescription_filled_status')
           ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
           ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
           ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
            ->groupBy('county')
            ->whereNull('prescription_filled_status.substitute_presc_id')
            ->where([ ['prescription_filled_status.created_at','<',$one_year_ago],
                      ['prescription_filled_status.created_at','>=',$two_year_ago],
                      ['pharmacy.county','like','%'.$trendL->county.'%'],

                     ])
             ->orderBy('totalq', 'desc')
              ->first();
           ?>
           <?php    if($RTrendsoldyL && ($trendL->totalq < $RTrendsoldyL->totalq))  { ?>
           <tr>
           <td>{{$i}}</td>
           <td>{{$trendL->county}}</td>
           <td class="text-danger"><i class="fa fa-level-down"></i><?php echo (round((($trendL->totalq - $RTrendsoldyL->totalq)/$trendL->totalq)*100,2)).'%' ;?></td>
           <td>{{$trendL->totalq}}</td>
           </tr>
            <?php  $i++  ?>
           <?php   } ?>
           @endforeach
             </tbody>
         </table>

     </div>
 </div>
</div>
</div>

<!--................................. CUSTOM ...........................-->



                 </div>
           </div>
<!--.................................END drugs ...........................-->
