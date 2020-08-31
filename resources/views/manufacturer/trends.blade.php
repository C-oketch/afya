@extends('layouts.manufacturer')
@section('title', 'Manufacturer')
@section('content')
<div class="content-page  equal-height">
 <div class="content">
   <div class="container">
      <div class="row">
        <h3>Trends</h3>
         <div class="col-lg-12">
         <div class="tabs-container">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#tab-1">Company</a></li>
              <li class=""><a data-toggle="tab" href="#tab-2">Drug</a></li>
              <li class=""><a data-toggle="tab" href="#tab-3">Region</a></li>
              <li class=""><a data-toggle="tab" href="#tab-4">Substitutions</a></li>
            </ul>
<br><br>
<div class="tab-content">
   <div id="tab-1" class="tab-pane active">
<h1 style="text-align:center">
   <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#tab-1a">Today</a></li>
    <li class=""><a data-toggle="tab" href="#tab-2a">This Week</a></li>
    <li class=""><a data-toggle="tab" href="#tab-3a">This Month</a></li>
    <li class=""><a data-toggle="tab" href="#tab-4a">This Year</a></li>
    <li class=""><a data-toggle="tab" href="#tab-5a">Custom</a></li>
   </ul>
</h1>

  <div class="tab-content">
    <div id="tab-1a" class="tab-pane active">
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
                        <th>Company</th>
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

                     $Trendsale = DB::table('prescription_filled_status')
                         ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                         ->join('druglists','druglists.id','=','prescription_details.drug_id')
                         ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                           ->groupBy('Manufacturer')
                           ->whereNull('prescription_filled_status.substitute_presc_id')
                           ->where([ ['prescription_filled_status.created_at','<',$today],
                                     ['prescription_filled_status.created_at','>=',$yesterday],
                                    ])
                            ->orderBy('totalq', 'desc')
                            ->LIMIT(10)
                             ->get();
                             $i=1;
                          ?>

                @foreach($Trendsale as $trend)

            <?php  $Trendsold = DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                    ->join('druglists','druglists.id','=','prescription_details.drug_id')
                    ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                      ->groupBy('Manufacturer')
                      ->whereNull('prescription_filled_status.substitute_presc_id')
                      ->where([ ['prescription_filled_status.created_at','<',$yesterday],
                                ['prescription_filled_status.created_at','>=',$previous],
                                ['druglists.Manufacturer','like','%'.$trend->Manufacturer.'%'],

                               ])
                       ->orderBy('totalq', 'desc')
                        ->first();
                ?>
          <?php    if($Trendsold && ($trend->totalq > $Trendsold->totalq))  { ?>
                  <tr>
                    <td>{{$i}}</td>
                    <td>{{$trend->Manufacturer}}</td>
                    <td class="text-navy"> <i class="fa fa-level-up"></i><?php echo (round((($trend->totalq - $Trendsold->totalq)/$trend->totalq)*100,2)).'%' ;?></td>
                    <td>{{$trend->totalq}}</td>
                    </tr>
                      <?php  $i++  ?>
                  <?php   } ?>
                  @endforeach
                 <tr><td><h3>Losers</h3></td></tr>
                <?php   $TrendsaleL = DB::table('prescription_filled_status')
                      ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                      ->join('druglists','druglists.id','=','prescription_details.drug_id')
                      ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                        ->groupBy('Manufacturer')
                        ->whereNull('prescription_filled_status.substitute_presc_id')
                        ->where([ ['prescription_filled_status.created_at','<',$today],
                                  ['prescription_filled_status.created_at','>=',$yesterday],
                                 ])
                         ->orderBy('totalq', 'desc')
                         ->LIMIT(10)
                          ->get();
                          $i=1;
                       ?>

                  @foreach($TrendsaleL as $trendL)

                  <?php  $TrendsoldL = DB::table('prescription_filled_status')
                  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                  ->join('druglists','druglists.id','=','prescription_details.drug_id')
                  ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                   ->groupBy('Manufacturer')
                   ->whereNull('prescription_filled_status.substitute_presc_id')
                   ->where([ ['prescription_filled_status.created_at','<',$yesterday],
                             ['prescription_filled_status.created_at','>=',$previous],
                             ['druglists.Manufacturer','like','%'.$trendL->Manufacturer.'%'],

                            ])
                    ->orderBy('totalq', 'desc')
                     ->first();
                  ?>
                  <?php    if($TrendsoldL && ($trendL->totalq < $TrendsoldL->totalq))  { ?>
                  <tr>
                  <td>{{$i}}</td>
                  <td>{{$trendL->Manufacturer}}</td>
                  <td class="text-danger"><i class="fa fa-level-down"></i><?php echo (round((($trendL->totalq - $TrendsoldL->totalq)/$trendL->totalq)*100,2)).'%' ;?></td>
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
  <div id="tab-2a" class="tab-pane">
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
                      <th>Company</th>
                      <th>Change</th>
                      <th>Total Sales</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                $Trendsalew = DB::table('prescription_filled_status')
                       ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                       ->join('druglists','druglists.id','=','prescription_details.drug_id')
                       ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                         ->groupBy('Manufacturer')
                         ->whereNull('prescription_filled_status.substitute_presc_id')
                         ->where([ ['prescription_filled_status.created_at','<',$today],
                                   ['prescription_filled_status.created_at','>=',$one_week_ago],
                                  ])
                          ->orderBy('totalq', 'desc')
                          ->LIMIT(10)
                           ->get();
                           $i=1;
                        ?>

              @foreach($Trendsalew as $trend)

          <?php  $Trendsoldw = DB::table('prescription_filled_status')
                  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                  ->join('druglists','druglists.id','=','prescription_details.drug_id')
                  ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                    ->groupBy('Manufacturer')
                    ->whereNull('prescription_filled_status.substitute_presc_id')
                    ->where([ ['prescription_filled_status.created_at','<',$one_week_ago],
                              ['prescription_filled_status.created_at','>=',$two_week_ago],
                              ['druglists.Manufacturer','like','%'.$trend->Manufacturer.'%'],

                             ])
                     ->orderBy('totalq', 'desc')
                      ->first();
              ?>
        <?php    if($Trendsoldw && ($trend->totalq > $Trendsoldw->totalq))  { ?>
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$trend->Manufacturer}}</td>
                  <td class="text-navy"> <i class="fa fa-level-up"></i><?php echo (round((($trend->totalq - $Trendsoldw->totalq)/$trend->totalq)*100,2)).'%' ;?></td>
                  <td>{{$trend->totalq}}</td>
                  </tr>
                    <?php  $i++  ?>
                <?php   } ?>
                @endforeach
               <tr><td><h3>Losers</h3></td></tr>
              <?php   $TrendsalewL = DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                    ->join('druglists','druglists.id','=','prescription_details.drug_id')
                    ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                      ->groupBy('Manufacturer')
                      ->whereNull('prescription_filled_status.substitute_presc_id')
                      ->where([ ['prescription_filled_status.created_at','<',$today],
                                ['prescription_filled_status.created_at','>=',$one_week_ago],
                               ])
                       ->orderBy('totalq', 'desc')
                       ->LIMIT(10)
                        ->get();
                        $i=1;
                     ?>

                @foreach($TrendsalewL as $trendL)

                <?php  $TrendsoldwL = DB::table('prescription_filled_status')
                ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                ->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                 ->groupBy('Manufacturer')
                 ->whereNull('prescription_filled_status.substitute_presc_id')
                 ->where([ ['prescription_filled_status.created_at','<',$one_week_ago],
                           ['prescription_filled_status.created_at','>=',$two_week_ago],
                           ['druglists.Manufacturer','like','%'.$trendL->Manufacturer.'%'],

                          ])
                  ->orderBy('totalq', 'desc')
                   ->first();
                ?>
                <?php    if($TrendsoldwL && ($trendL->totalq < $TrendsoldwL->totalq))  { ?>
                <tr>
                <td>{{$i}}</td>
                <td>{{$trendL->Manufacturer}}</td>
                <td class="text-danger"><i class="fa fa-level-down"></i><?php echo (round((($trendL->totalq - $TrendsoldwL->totalq)/$trendL->totalq)*100,2)).'%' ;?></td>
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

  <div id="tab-3a" class="tab-pane">
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
                      <th>Company</th>
                      <th>Change</th>
                      <th>Total Sales</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                $Trendsalem = DB::table('prescription_filled_status')
                       ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                       ->join('druglists','druglists.id','=','prescription_details.drug_id')
                       ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                         ->groupBy('Manufacturer')
                         ->whereNull('prescription_filled_status.substitute_presc_id')
                         ->where([ ['prescription_filled_status.created_at','<',$today],
                                   ['prescription_filled_status.created_at','>=',$one_month_ago],
                                  ])
                          ->orderBy('totalq', 'desc')
                          ->LIMIT(10)
                           ->get();
                           $i=1;
                        ?>

              @foreach($Trendsalem as $trend)

          <?php  $Trendsoldm = DB::table('prescription_filled_status')
                  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                  ->join('druglists','druglists.id','=','prescription_details.drug_id')
                  ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                    ->groupBy('Manufacturer')
                    ->whereNull('prescription_filled_status.substitute_presc_id')
                    ->where([ ['prescription_filled_status.created_at','<',$one_month_ago],
                              ['prescription_filled_status.created_at','>=',$two_month_ago],
                              ['druglists.Manufacturer','like','%'.$trend->Manufacturer.'%'],

                             ])
                     ->orderBy('totalq', 'desc')
                      ->first();
              ?>
        <?php    if($Trendsoldm && ($trend->totalq > $Trendsoldm->totalq))  { ?>
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$trend->Manufacturer}}</td>
                  <td class="text-navy"> <i class="fa fa-level-up"></i><?php echo (round((($trend->totalq - $Trendsoldm->totalq)/$trend->totalq)*100,2)).'%' ;?></td>
                  <td>{{$trend->totalq}}</td>
                  </tr>
                    <?php  $i++  ?>
                <?php   } ?>
                @endforeach
               <tr><td><h3>Losers</h3></td></tr>
              <?php   $TrendsalemL = DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                    ->join('druglists','druglists.id','=','prescription_details.drug_id')
                    ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                      ->groupBy('Manufacturer')
                      ->whereNull('prescription_filled_status.substitute_presc_id')
                      ->where([ ['prescription_filled_status.created_at','<',$today],
                                ['prescription_filled_status.created_at','>=',$one_month_ago],
                               ])
                       ->orderBy('totalq', 'desc')
                       ->LIMIT(10)
                        ->get();
                        $i=1;
                     ?>

                @foreach($TrendsalemL as $trendL)

                <?php  $TrendsoldmL = DB::table('prescription_filled_status')
                ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                ->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                 ->groupBy('Manufacturer')
                 ->whereNull('prescription_filled_status.substitute_presc_id')
                 ->where([ ['prescription_filled_status.created_at','<',$one_month_ago],
                           ['prescription_filled_status.created_at','>=',$two_month_ago],
                           ['druglists.Manufacturer','like','%'.$trendL->Manufacturer.'%'],

                          ])
                  ->orderBy('totalq', 'desc')
                   ->first();
                ?>
                <?php    if($TrendsoldmL && ($trendL->totalq < $TrendsoldmL->totalq))  { ?>
                <tr>
                <td>{{$i}}</td>
                <td>{{$trendL->Manufacturer}}</td>
                <td class="text-danger"><i class="fa fa-level-down"></i><?php echo (round((($trendL->totalq - $TrendsoldmL->totalq)/$trendL->totalq)*100,2)).'%' ;?></td>
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
<div id="tab-4a" class="tab-pane">
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
                    <th>Company</th>
                    <th>Change</th>
                    <th>Total Sales</th>
                </tr>
                </thead>
                <tbody>
                <?php
              $Trendsaley = DB::table('prescription_filled_status')
                     ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                     ->join('druglists','druglists.id','=','prescription_details.drug_id')
                     ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                       ->groupBy('Manufacturer')
                       ->whereNull('prescription_filled_status.substitute_presc_id')
                       ->where([ ['prescription_filled_status.created_at','<',$today],
                                 ['prescription_filled_status.created_at','>=',$one_year_ago],
                                ])
                        ->orderBy('totalq', 'desc')
                        ->LIMIT(10)
                         ->get();
                         $i=1;
                      ?>

            @foreach($Trendsaley as $trend)

        <?php  $Trendsoldy = DB::table('prescription_filled_status')
                ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                ->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                  ->groupBy('Manufacturer')
                  ->whereNull('prescription_filled_status.substitute_presc_id')
                  ->where([ ['prescription_filled_status.created_at','<',$one_year_ago],
                            ['prescription_filled_status.created_at','>=',$two_year_ago],
                            ['druglists.Manufacturer','like','%'.$trend->Manufacturer.'%'],

                           ])
                   ->orderBy('totalq', 'desc')
                    ->first();
            ?>
      <?php    if($Trendsoldy && ($trend->totalq > $Trendsoldy->totalq))  { ?>
              <tr>
                <td>{{$i}}</td>
                <td>{{$trend->Manufacturer}}</td>
                <td class="text-navy"> <i class="fa fa-level-up"></i><?php echo (round((($trend->totalq - $Trendsoldy->totalq)/$trend->totalq)*100,2)).'%' ;?></td>
                <td>{{$trend->totalq}}</td>
                </tr>
                  <?php  $i++  ?>
              <?php   } ?>
              @endforeach
             <tr><td><h3>Losers</h3></td></tr>
            <?php   $TrendsaleyL = DB::table('prescription_filled_status')
                  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                  ->join('druglists','druglists.id','=','prescription_details.drug_id')
                  ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                    ->groupBy('Manufacturer')
                    ->whereNull('prescription_filled_status.substitute_presc_id')
                    ->where([ ['prescription_filled_status.created_at','<',$today],
                              ['prescription_filled_status.created_at','>=',$one_year_ago],
                             ])
                     ->orderBy('totalq', 'desc')
                     ->LIMIT(10)
                      ->get();
                      $i=1;
                   ?>

              @foreach($TrendsaleyL as $trendL)

              <?php  $TrendsoldyL = DB::table('prescription_filled_status')
              ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
              ->join('druglists','druglists.id','=','prescription_details.drug_id')
              ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
               ->groupBy('Manufacturer')
               ->whereNull('prescription_filled_status.substitute_presc_id')
               ->where([ ['prescription_filled_status.created_at','<',$one_year_ago],
                         ['prescription_filled_status.created_at','>=',$two_year_ago],
                         ['druglists.Manufacturer','like','%'.$trendL->Manufacturer.'%'],

                        ])
                ->orderBy('totalq', 'desc')
                 ->first();
              ?>
              <?php    if($TrendsoldyL && ($trendL->totalq < $TrendsoldyL->totalq))  { ?>
              <tr>
              <td>{{$i}}</td>
              <td>{{$trendL->Manufacturer}}</td>
              <td class="text-danger"><i class="fa fa-level-down"></i><?php echo (round((($trendL->totalq - $TrendsoldyL->totalq)/$trendL->totalq)*100,2)).'%' ;?></td>
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
<!--.................................END Company ...........................-->
  @include('manufacturer.trendsdrugs')
  <!--.................................END Drugs ...........................-->
  @include('manufacturer.trendsregion')
  <!--.................................END Reion ...........................-->
  @include('manufacturer.trendsdrugsubstitution')
  <!--.................................END Reion ...........................-->






                </div>
              </div>
            </div>
             @include('includes.default.footer')
                   </div><!--container-->
                </div><!--content -->
            </div><!--content page-->
@endsection
