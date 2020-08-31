<div id="tab-2" class="tab-pane">
<h1 style="text-align:center">
<ul class="nav nav-tabs">
 <li class="active"><a data-toggle="tab" href="#tab-21a">Today</a></li>
 <li class=""><a data-toggle="tab" href="#tab-22a">This Week</a></li>
 <li class=""><a data-toggle="tab" href="#tab-23a">This Month</a></li>
 <li class=""><a data-toggle="tab" href="#tab-24a">This Year</a></li>
 <li class=""><a data-toggle="tab" href="#tab-25a">Custom</a></li>
</ul>
</h1>

<div class="tab-content">
 <div id="tab-21a" class="tab-pane active">
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

                  $DTrendsale = DB::table('prescription_filled_status')
                      ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                      ->join('druglists','druglists.id','=','prescription_details.drug_id')
                      ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                        ->groupBy('drugname')
                        ->whereNull('prescription_filled_status.substitute_presc_id')
                        ->where([ ['prescription_filled_status.created_at','<',$today],
                                  ['prescription_filled_status.created_at','>=',$yesterday],
                                 ])
                         ->orderBy('totalq', 'desc')
                         ->LIMIT(10)
                          ->get();
                          $i=1;
                       ?>

             @foreach($DTrendsale as $trend)

         <?php  $DTrendsold = DB::table('prescription_filled_status')
                 ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                 ->join('druglists','druglists.id','=','prescription_details.drug_id')
                 ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                   ->groupBy('drugname')
                   ->whereNull('prescription_filled_status.substitute_presc_id')
                   ->where([ ['prescription_filled_status.created_at','<',$yesterday],
                             ['prescription_filled_status.created_at','>=',$previous],
                             ['druglists.drugname','like','%'.$trend->drugname.'%'],

                            ])
                    ->orderBy('totalq', 'desc')
                     ->first();
             ?>
       <?php    if($DTrendsold && ($trend->totalq > $DTrendsold->totalq))  { ?>
               <tr>
                 <td>{{$i}}</td>
                 <td>{{$trend->drugname}}</td>
                 <td class="text-navy"> <i class="fa fa-level-up"></i><?php echo (round((($trend->totalq - $DTrendsold->totalq)/$trend->totalq)*100,2)).'%' ;?></td>
                 <td>{{$trend->totalq}}</td>
                 </tr>
                   <?php  $i++  ?>
               <?php   } ?>
               @endforeach
              <tr><td><h3>Losers</h3></td></tr>
             <?php   $DTrendsaleL = DB::table('prescription_filled_status')
                   ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                   ->join('druglists','druglists.id','=','prescription_details.drug_id')
                   ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                     ->groupBy('drugname')
                     ->whereNull('prescription_filled_status.substitute_presc_id')
                     ->where([ ['prescription_filled_status.created_at','<',$today],
                               ['prescription_filled_status.created_at','>=',$yesterday],
                              ])
                      ->orderBy('totalq', 'desc')
                      ->LIMIT(10)
                       ->get();
                       $i=1;
                    ?>

               @foreach($DTrendsaleL as $trendL)

               <?php  $DTrendsoldL = DB::table('prescription_filled_status')
               ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
               ->join('druglists','druglists.id','=','prescription_details.drug_id')
               ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                ->groupBy('drugname')
                ->whereNull('prescription_filled_status.substitute_presc_id')
                ->where([ ['prescription_filled_status.created_at','<',$yesterday],
                          ['prescription_filled_status.created_at','>=',$previous],
                          ['druglists.drugname','like','%'.$trendL->drugname.'%'],

                         ])
                 ->orderBy('totalq', 'desc')
                  ->first();
               ?>
               <?php    if($DTrendsoldL && ($trendL->totalq < $DTrendsoldL->totalq))  { ?>
               <tr>
               <td>{{$i}}</td>
               <td>{{$trendL->drugname}}</td>
               <td class="text-danger"><i class="fa fa-level-down"></i><?php echo (round((($trendL->totalq - $DTrendsoldL->totalq)/$trendL->totalq)*100,2)).'%' ;?></td>
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
<div id="tab-22a" class="tab-pane">
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
             $DTrendsalew = DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                    ->join('druglists','druglists.id','=','prescription_details.drug_id')
                    ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                      ->groupBy('drugname')
                      ->whereNull('prescription_filled_status.substitute_presc_id')
                      ->where([ ['prescription_filled_status.created_at','<',$today],
                                ['prescription_filled_status.created_at','>=',$one_week_ago],
                               ])
                       ->orderBy('totalq', 'desc')
                       ->LIMIT(10)
                        ->get();
                        $i=1;
                     ?>

           @foreach($DTrendsalew as $trend)

       <?php  $DTrendsoldw = DB::table('prescription_filled_status')
               ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
               ->join('druglists','druglists.id','=','prescription_details.drug_id')
               ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                 ->groupBy('drugname')
                 ->whereNull('prescription_filled_status.substitute_presc_id')
                 ->where([ ['prescription_filled_status.created_at','<',$one_week_ago],
                           ['prescription_filled_status.created_at','>=',$two_week_ago],
                           ['druglists.drugname','like','%'.$trend->drugname.'%'],

                          ])
                  ->orderBy('totalq', 'desc')
                   ->first();
           ?>
     <?php    if($DTrendsoldw && ($trend->totalq > $DTrendsoldw->totalq))  { ?>
             <tr>
               <td>{{$i}}</td>
               <td>{{$trend->drugname}}</td>
               <td class="text-navy"> <i class="fa fa-level-up"></i><?php echo (round((($trend->totalq - $DTrendsoldw->totalq)/$trend->totalq)*100,2)).'%' ;?></td>
               <td>{{$trend->totalq}}</td>
               </tr>
                 <?php  $i++  ?>
             <?php   } ?>
             @endforeach
            <tr><td><h3>Losers</h3></td></tr>
           <?php   $DTrendsalewL = DB::table('prescription_filled_status')
                 ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                 ->join('druglists','druglists.id','=','prescription_details.drug_id')
                 ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                   ->groupBy('drugname')
                   ->whereNull('prescription_filled_status.substitute_presc_id')
                   ->where([ ['prescription_filled_status.created_at','<',$today],
                             ['prescription_filled_status.created_at','>=',$one_week_ago],
                            ])
                    ->orderBy('totalq', 'desc')
                    ->LIMIT(10)
                     ->get();
                     $i=1;
                  ?>

             @foreach($DTrendsalewL as $trendL)

             <?php  $DTrendsoldwL = DB::table('prescription_filled_status')
             ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
             ->join('druglists','druglists.id','=','prescription_details.drug_id')
             ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
              ->groupBy('drugname')
              ->whereNull('prescription_filled_status.substitute_presc_id')
              ->where([ ['prescription_filled_status.created_at','<',$one_week_ago],
                        ['prescription_filled_status.created_at','>=',$two_week_ago],
                        ['druglists.drugname','like','%'.$trendL->drugname.'%'],

                       ])
               ->orderBy('totalq', 'desc')
                ->first();
             ?>
             <?php    if($DTrendsoldwL && ($trendL->totalq < $DTrendsoldwL->totalq))  { ?>
             <tr>
             <td>{{$i}}</td>
             <td>{{$trendL->drugname}}</td>
             <td class="text-danger"><i class="fa fa-level-down"></i><?php echo (round((($trendL->totalq - $DTrendsoldwL->totalq)/$trendL->totalq)*100,2)).'%' ;?></td>
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

<div id="tab-23a" class="tab-pane">
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
             $DTrendsalem = DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                    ->join('druglists','druglists.id','=','prescription_details.drug_id')
                    ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                      ->groupBy('drugname')
                      ->whereNull('prescription_filled_status.substitute_presc_id')
                      ->where([ ['prescription_filled_status.created_at','<',$today],
                                ['prescription_filled_status.created_at','>=',$one_month_ago],
                               ])
                       ->orderBy('totalq', 'desc')
                       ->LIMIT(10)
                        ->get();
                        $i=1;
                     ?>

           @foreach($DTrendsalem as $trend)

       <?php  $DTrendsoldm = DB::table('prescription_filled_status')
               ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
               ->join('druglists','druglists.id','=','prescription_details.drug_id')
               ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                 ->groupBy('drugname')
                 ->whereNull('prescription_filled_status.substitute_presc_id')
                 ->where([ ['prescription_filled_status.created_at','<',$one_month_ago],
                           ['prescription_filled_status.created_at','>=',$two_month_ago],
                           ['druglists.drugname','like','%'.$trend->drugname.'%'],

                          ])
                  ->orderBy('totalq', 'desc')
                   ->first();
           ?>
     <?php    if($DTrendsoldm && ($trend->totalq > $DTrendsoldm->totalq))  { ?>
             <tr>
               <td>{{$i}}</td>
               <td>{{$trend->drugname}}</td>
               <td class="text-navy"> <i class="fa fa-level-up"></i><?php echo (round((($trend->totalq - $DTrendsoldm->totalq)/$trend->totalq)*100,2)).'%' ;?></td>
               <td>{{$trend->totalq}}</td>
               </tr>
                 <?php  $i++  ?>
             <?php   } ?>
             @endforeach
            <tr><td><h3>Losers</h3></td></tr>
           <?php   $DTrendsalemL = DB::table('prescription_filled_status')
                 ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                 ->join('druglists','druglists.id','=','prescription_details.drug_id')
                 ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                   ->groupBy('drugname')
                   ->whereNull('prescription_filled_status.substitute_presc_id')
                   ->where([ ['prescription_filled_status.created_at','<',$today],
                             ['prescription_filled_status.created_at','>=',$one_month_ago],
                            ])
                    ->orderBy('totalq', 'desc')
                    ->LIMIT(10)
                     ->get();
                     $i=1;
                  ?>

             @foreach($DTrendsalemL as $trendL)

             <?php  $DTrendsoldmL = DB::table('prescription_filled_status')
             ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
             ->join('druglists','druglists.id','=','prescription_details.drug_id')
             ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
              ->groupBy('drugname')
              ->whereNull('prescription_filled_status.substitute_presc_id')
              ->where([ ['prescription_filled_status.created_at','<',$one_month_ago],
                        ['prescription_filled_status.created_at','>=',$two_month_ago],
                        ['druglists.drugname','like','%'.$trendL->drugname.'%'],

                       ])
               ->orderBy('totalq', 'desc')
                ->first();
             ?>
             <?php    if($DTrendsoldmL && ($trendL->totalq < $DTrendsoldmL->totalq))  { ?>
             <tr>
             <td>{{$i}}</td>
             <td>{{$trendL->drugname}}</td>
             <td class="text-danger"><i class="fa fa-level-down"></i><?php echo (round((($trendL->totalq - $DTrendsoldmL->totalq)/$trendL->totalq)*100,2)).'%' ;?></td>
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
<div id="tab-24a" class="tab-pane">
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
           $DTrendsaley = DB::table('prescription_filled_status')
                  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                  ->join('druglists','druglists.id','=','prescription_details.drug_id')
                  ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                    ->groupBy('drugname')
                    ->whereNull('prescription_filled_status.substitute_presc_id')
                    ->where([ ['prescription_filled_status.created_at','<',$today],
                              ['prescription_filled_status.created_at','>=',$one_year_ago],
                             ])
                     ->orderBy('totalq', 'desc')
                     ->LIMIT(10)
                      ->get();
                      $i=1;
                   ?>

         @foreach($DTrendsaley as $trend)

     <?php  $DTrendsoldy = DB::table('prescription_filled_status')
             ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
             ->join('druglists','druglists.id','=','prescription_details.drug_id')
             ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
               ->groupBy('drugname')
               ->whereNull('prescription_filled_status.substitute_presc_id')
               ->where([ ['prescription_filled_status.created_at','<',$one_year_ago],
                         ['prescription_filled_status.created_at','>=',$two_year_ago],
                         ['druglists.drugname','like','%'.$trend->drugname.'%'],

                        ])
                ->orderBy('totalq', 'desc')
                 ->first();
         ?>
   <?php    if($DTrendsoldy && ($trend->totalq > $DTrendsoldy->totalq))  { ?>
           <tr>
             <td>{{$i}}</td>
             <td>{{$trend->drugname}}</td>
             <td class="text-navy"> <i class="fa fa-level-up"></i><?php echo (round((($trend->totalq - $DTrendsoldy->totalq)/$trend->totalq)*100,2)).'%' ;?></td>
             <td>{{$trend->totalq}}</td>
             </tr>
               <?php  $i++  ?>
           <?php   } ?>
           @endforeach
          <tr><td><h3>Losers</h3></td></tr>
         <?php   $DTrendsaleyL = DB::table('prescription_filled_status')
               ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
               ->join('druglists','druglists.id','=','prescription_details.drug_id')
               ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                 ->groupBy('drugname')
                 ->whereNull('prescription_filled_status.substitute_presc_id')
                 ->where([ ['prescription_filled_status.created_at','<',$today],
                           ['prescription_filled_status.created_at','>=',$one_year_ago],
                          ])
                  ->orderBy('totalq', 'desc')
                  ->LIMIT(10)
                   ->get();
                   $i=1;
                ?>

           @foreach($DTrendsaleyL as $trendL)

           <?php  $DTrendsoldyL = DB::table('prescription_filled_status')
           ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
           ->join('druglists','druglists.id','=','prescription_details.drug_id')
           ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
            ->groupBy('drugname')
            ->whereNull('prescription_filled_status.substitute_presc_id')
            ->where([ ['prescription_filled_status.created_at','<',$one_year_ago],
                      ['prescription_filled_status.created_at','>=',$two_year_ago],
                      ['druglists.drugname','like','%'.$trendL->drugname.'%'],

                     ])
             ->orderBy('totalq', 'desc')
              ->first();
           ?>
           <?php    if($DTrendsoldyL && ($trendL->totalq < $DTrendsoldyL->totalq))  { ?>
           <tr>
           <td>{{$i}}</td>
           <td>{{$trendL->drugname}}</td>
           <td class="text-danger"><i class="fa fa-level-down"></i><?php echo (round((($trendL->totalq - $DTrendsoldyL->totalq)/$trendL->totalq)*100,2)).'%' ;?></td>
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
