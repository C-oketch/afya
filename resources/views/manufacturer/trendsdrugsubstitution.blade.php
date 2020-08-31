<div id="tab-4" class="tab-pane">
<h1 style="text-align:center">
<ul class="nav nav-tabs">
 <li class="active"><a data-toggle="tab" href="#tab-41a">Today</a></li>
 <li class=""><a data-toggle="tab" href="#tab-42a">This Week</a></li>
 <li class=""><a data-toggle="tab" href="#tab-43a">This Month</a></li>
 <li class=""><a data-toggle="tab" href="#tab-44a">This Year</a></li>
 <li class=""><a data-toggle="tab" href="#tab-45a">Custom</a></li>
</ul>
</h1>

<div class="tab-content">
 <div id="tab-41a" class="tab-pane active">
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

                 $sdTrendsale = DB::table('substitute_presc_details')
                    ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
                    ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                    ->select('drug_id','drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                    ->where([ ['prescription_filled_status.created_at','<',$today],
                              ['prescription_filled_status.created_at','>=',$yesterday],
                             ])
                      ->groupBy('drugname')
                      ->orderBy('totalq', 'desc')
                       ->LIMIT(10)
                        ->get();
                        $i=1;
                     ?>

            @foreach($sdTrendsale as $trend)

        <?php  $sdTrendsold = DB::table('substitute_presc_details')
           ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
           ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
           ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
            ->where([ ['prescription_filled_status.created_at','<',$yesterday],
                            ['prescription_filled_status.created_at','>=',$previous],
                            ['druglists.id','=',$trend->drug_id],
                               ])
                ->first();
            ?>
      <?php    if($sdTrendsold && ($trend->totalq > $sdTrendsold->totalq))  { ?>
              <tr>
                <td>{{$i}}</td>
                <td>{{$trend->drugname}}</td>
                <td class="text-navy"> <i class="fa fa-level-up"></i><?php echo (round((($trend->totalq - $sdTrendsold->totalq)/$trend->totalq)*100,2)).'%' ;?></td>
                <td>{{$trend->totalq}}</td>
                </tr>
                  <?php  $i++  ?>
              <?php   } ?>
              @endforeach
             <tr><td><h3>Losers</h3></td></tr>
            <?php   $sdTrendsaleL = DB::table('substitute_presc_details')
               ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
               ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
               ->select('drug_id','drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
               ->where([ ['prescription_filled_status.created_at','<',$today],
                         ['prescription_filled_status.created_at','>=',$yesterday],
                        ])
                 ->groupBy('drugname')
                 ->orderBy('totalq', 'desc')
                  ->LIMIT(10)
                   ->get();
                      $i=1;
                   ?>

              @foreach($sdTrendsaleL as $trendL)

              <?php  $sdTrendsoldL = DB::table('substitute_presc_details')
                 ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
                 ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                 ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                  ->where([ ['prescription_filled_status.created_at','<',$yesterday],
                                  ['prescription_filled_status.created_at','>=',$previous],
                                  ['druglists.id','=',$trend->drug_id],
                                     ])
                      ->first();
              ?>
              <?php    if($sdTrendsoldL && ($trendL->totalq < $sdTrendsoldL->totalq))  { ?>
              <tr>
              <td>{{$i}}</td>
              <td>{{$trendL->drugname}}</td>
              <td class="text-danger"><i class="fa fa-level-down"></i><?php echo (round((($trendL->totalq - $sdTrendsoldL->totalq)/$trendL->totalq)*100,2)).'%' ;?></td>
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
<div id="tab-42a" class="tab-pane">
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

               $sdTrendsalew = DB::table('substitute_presc_details')
                  ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
                  ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                  ->select('drug_id','drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                  ->where([ ['prescription_filled_status.created_at','<',$today],
                            ['prescription_filled_status.created_at','>=',$one_week_ago],
                           ])
                    ->groupBy('drugname')
                    ->orderBy('totalq', 'desc')
                     ->LIMIT(10)
                      ->get();
                      $i=1;
                   ?>

               @foreach($sdTrendsalew as $trend)

               <?php  $sdTrendsoldw = DB::table('substitute_presc_details')
               ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
               ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
               ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
               ->where([ ['prescription_filled_status.created_at','<',$one_week_ago],
                          ['prescription_filled_status.created_at','>=',$two_week_ago],
                          ['druglists.id','=',$trend->drug_id],
                             ])
               ->first();
               ?>
               <?php    if($sdTrendsoldw && ($trend->totalq > $sdTrendsoldw->totalq))  { ?>
               <tr>
               <td>{{$i}}</td>
               <td>{{$trend->drugname}}</td>
               <td class="text-navy"> <i class="fa fa-level-up"></i><?php echo (round((($trend->totalq - $sdTrendsoldw->totalq)/$trend->totalq)*100,2)).'%' ;?></td>
               <td>{{$trend->totalq}}</td>
               </tr>
                <?php  $i++  ?>
               <?php   } ?>
               @endforeach
               <tr><td><h3>Losers</h3></td></tr>
               <?php   $sdTrendsalewL = DB::table('substitute_presc_details')
               ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
               ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
               ->select('drug_id','drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
               ->where([ ['prescription_filled_status.created_at','<',$today],
                       ['prescription_filled_status.created_at','>=',$one_week_ago],
                      ])
               ->groupBy('drugname')
               ->orderBy('totalq', 'desc')
                ->LIMIT(10)
                 ->get();
                    $i=1;
                 ?>

               @foreach($sdTrendsalewL as $trendL)

               <?php  $sdTrendsoldwL = DB::table('substitute_presc_details')
               ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
               ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
               ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                ->where([ ['prescription_filled_status.created_at','<',$one_week_ago],
                                ['prescription_filled_status.created_at','>=',$two_week_ago],
                                ['druglists.id','=',$trend->drug_id],
                                   ])
                    ->first();
               ?>
               <?php    if($sdTrendsoldwL && ($trendL->totalq < $sdTrendsoldwL->totalq))  { ?>
               <tr>
               <td>{{$i}}</td>
               <td>{{$trendL->drugname}}</td>
               <td class="text-danger"><i class="fa fa-level-down"></i><?php echo (round((($trendL->totalq - $sdTrendsoldwL->totalq)/$trendL->totalq)*100,2)).'%' ;?></td>
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

<div id="tab-43a" class="tab-pane">
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

               $sdTrendsalem = DB::table('substitute_presc_details')
                  ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
                  ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                  ->select('drug_id','drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                  ->where([ ['prescription_filled_status.created_at','<',$today],
                            ['prescription_filled_status.created_at','>=',$one_month_ago],
                           ])
                    ->groupBy('drugname')
                    ->orderBy('totalq', 'desc')
                     ->LIMIT(10)
                      ->get();
                      $i=1;
                   ?>

               @foreach($sdTrendsalem as $trend)

               <?php  $sdTrendsoldm = DB::table('substitute_presc_details')
               ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
               ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
               ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
               ->where([ ['prescription_filled_status.created_at','<',$one_month_ago],
                          ['prescription_filled_status.created_at','>=',$two_month_ago],
                          ['druglists.id','=',$trend->drug_id],
                             ])
               ->first();
               ?>
               <?php    if($sdTrendsoldm && ($trend->totalq > $sdTrendsoldm->totalq))  { ?>
               <tr>
               <td>{{$i}}</td>
               <td>{{$trend->drugname}}</td>
               <td class="text-navy"> <i class="fa fa-level-up"></i><?php echo (round((($trend->totalq - $sdTrendsoldm->totalq)/$trend->totalq)*100,2)).'%' ;?></td>
               <td>{{$trend->totalq}}</td>
               </tr>
                <?php  $i++  ?>
               <?php   } ?>
               @endforeach
               <tr><td><h3>Losers</h3></td></tr>
               <?php   $sdTrendsalemL = DB::table('substitute_presc_details')
               ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
               ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
               ->select('drug_id','drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
               ->where([ ['prescription_filled_status.created_at','<',$today],
                       ['prescription_filled_status.created_at','>=',$one_month_ago],
                      ])
               ->groupBy('drugname')
               ->orderBy('totalq', 'desc')
                ->LIMIT(10)
                 ->get();
                    $i=1;
                 ?>

               @foreach($sdTrendsalemL as $trendL)

               <?php  $sdTrendsoldmL = DB::table('substitute_presc_details')
               ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
               ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
               ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                ->where([ ['prescription_filled_status.created_at','<',$one_month_ago],
                                ['prescription_filled_status.created_at','>=',$two_month_ago],
                                ['druglists.id','=',$trend->drug_id],
                                   ])
                    ->first();
               ?>
               <?php    if($sdTrendsoldmL && ($trendL->totalq < $sdTrendsoldmL->totalq))  { ?>
               <tr>
               <td>{{$i}}</td>
               <td>{{$trendL->drugname}}</td>
               <td class="text-danger"><i class="fa fa-level-down"></i><?php echo (round((($trendL->totalq - $sdTrendsoldmL->totalq)/$trendL->totalq)*100,2)).'%' ;?></td>
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
<div id="tab-44a" class="tab-pane">
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

             $sdTrendsaley = DB::table('substitute_presc_details')
                ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
                ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                ->select('drug_id','drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                ->where([ ['prescription_filled_status.created_at','<',$today],
                          ['prescription_filled_status.created_at','>=',$one_year_ago],
                         ])
                  ->groupBy('drugname')
                  ->orderBy('totalq', 'desc')
                   ->LIMIT(10)
                    ->get();
                    $i=1;
                 ?>

             @foreach($sdTrendsaley as $trend)

             <?php  $sdTrendsoldy = DB::table('substitute_presc_details')
             ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
             ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
             ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
             ->where([ ['prescription_filled_status.created_at','<',$one_year_ago],
                        ['prescription_filled_status.created_at','>=',$two_year_ago],
                        ['druglists.id','=',$trend->drug_id],
                           ])
             ->first();
             ?>
             <?php    if($sdTrendsoldy && ($trend->totalq > $sdTrendsoldy->totalq))  { ?>
             <tr>
             <td>{{$i}}</td>
             <td>{{$trend->drugname}}</td>
             <td class="text-navy"> <i class="fa fa-level-up"></i><?php echo (round((($trend->totalq - $sdTrendsoldy->totalq)/$trend->totalq)*100,2)).'%' ;?></td>
             <td>{{$trend->totalq}}</td>
             </tr>
              <?php  $i++  ?>
             <?php   } ?>
             @endforeach
             <tr><td><h3>Losers</h3></td></tr>
             <?php   $sdTrendsaleyL = DB::table('substitute_presc_details')
             ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
             ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
             ->select('drug_id','drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
             ->where([ ['prescription_filled_status.created_at','<',$today],
                     ['prescription_filled_status.created_at','>=',$one_year_ago],
                    ])
             ->groupBy('drugname')
             ->orderBy('totalq', 'desc')
              ->LIMIT(10)
               ->get();
                  $i=1;
               ?>

             @foreach($sdTrendsaleyL as $trendL)

             <?php  $sdTrendsoldyL = DB::table('substitute_presc_details')
             ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
             ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
             ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
              ->where([ ['prescription_filled_status.created_at','<',$one_year_ago],
                              ['prescription_filled_status.created_at','>=',$two_year_ago],
                              ['druglists.id','=',$trend->drug_id],
                                 ])
                  ->first();
             ?>
             <?php    if($sdTrendsoldyL && ($trendL->totalq < $sdTrendsoldyL->totalq))  { ?>
             <tr>
             <td>{{$i}}</td>
             <td>{{$trendL->drugname}}</td>
             <td class="text-danger"><i class="fa fa-level-down"></i><?php echo (round((($trendL->totalq - $sdTrendsoldyL->totalq)/$trendL->totalq)*100,2)).'%' ;?></td>
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
