 <div id="tab-2" class="tab-pane">
                             <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-21a">Today</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-22a">This Week</a></li>
                             <li class=""><a data-toggle="tab" href="#tab-23a">This Month</a></li>
                          <li class=""><a data-toggle="tab" href="#tab-24a">This Year</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-25a">Max</a></li>
                             <li class=""><a data-toggle="tab" href="#tab-26a">Custom</a></li>
                        </ul>
                        <br>
                        <div class="tab-content">
                          <!-- today sales -->
                          <div id="tab-21a" class="tab-pane active">
                                <div class="panel-body">
                                <div class="ibox float-e-margins">



                               <div class="col-md-12">
                              <div class="ibox-content">
                                <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >

                              <thead>
                            <tr>
                             <th>No</th>
                             <th>Region</th>

                             <th colspan="2">@if($Companiez11){{$Companiez11->Manufacturer}}@endif</th>
                            <th colspan="2">@if($Companiez1){{$Companiez1->Manufacturer}}@endif</th>
                             <th colspan="2">@if($Companiez2){{$Companiez2->Manufacturer}}@endif</th>
                              <th colspan="2">@if($Companiez3){{$Companiez3->Manufacturer}}@endif</th>
                              <th colspan="2">@if($Companiez4){{$Companiez4->Manufacturer}}@endif</th>
                              <th colspan="2">@if($Companiez5){{$Companiez5->Manufacturer}}@endif</th>

                             </tr>
                             <tr>
                             <th></th>
                              <th></th>

                              <th>Total Sales</th>
                              <th>Value</th>
                              <th>Total Sales</th>
                              <th>Value</th>
                              <th>Total Sales</th>
                              <th>Value</th>
                              <th>Total Sales</th>
                              <th>Value</th>
                              <th>Total Sales</th>
                              <th>Value</th>
                              <th>Total Sales</th>
                              <th>Value</th>


                              </tr>
                             </thead>

                          <tbody>



                  <?php
                  use Carbon\Carbon;
                  $todaysales = Carbon::today();
                      $i =1;
                       $r1t = DB::table('prescription_filled_status')
                          ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                          ->join('druglists','druglists.id','=','prescription_details.drug_id')
                          ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                          ->select('county as county', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
                            ->groupBy('county')
                            ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                                     ])
                            ->whereNull('prescription_filled_status.substitute_presc_id')
                             ->orderBy('totalq', 'desc')
                              ->get();
                             ?>
                  @foreach($r1t as $region)
                      <tr>
                  <td>{{$i}}</td>
                  <td>{{$region->county}}</td>
                  @if($Companiez11)
                <?php  $r1tm = DB::table('prescription_filled_status')
                     ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                     ->join('druglists','druglists.id','=','prescription_details.drug_id')
                     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                     ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                               ['pharmacy.county','=', $region->county],
                               ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
                       ->whereNull('prescription_filled_status.substitute_presc_id')
                      ->first();

                          $r1stm = DB::table('prescription_filled_status')
                             ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                             ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                             ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                             ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                             ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                                       ['pharmacy.county','=', $region->county],
                                       ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
                               ->whereNotNull('prescription_filled_status.substitute_presc_id')
                              ->first();

                                ?>
                   <td>{{($r1tm->totalq1 + $r1stm->totalq1)}}</td>
                   <td>{{($r1tm->total1 + $r1stm->total1)}}</td>
                   @endif
                @if($Companiez1)
                   <?php  $co1 = DB::table('prescription_filled_status')
                        ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                        ->join('druglists','druglists.id','=','prescription_details.drug_id')
                        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                        ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                                  ['pharmacy.county','=', $region->county],
                                  ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
                          ->whereNull('prescription_filled_status.substitute_presc_id')
                         ->first();

                   $co11 = DB::table('prescription_filled_status')
                      ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                      ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                      ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                      ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                      ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                                ['pharmacy.county','=', $region->county],
                                ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
                        ->whereNotNull('prescription_filled_status.substitute_presc_id')
                       ->first();

                         ?>
                             <td>{{($co1->totalq1 + $co11->totalq1)}}</td>
                             <td>{{($co1->total1 + $co11->total1)}}</td>
  @endif
  @if($Companiez2)
       <?php  $co2 = DB::table('prescription_filled_status')
            ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
            ->join('druglists','druglists.id','=','prescription_details.drug_id')
            ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
            ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
            ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                      ['pharmacy.county','=', $region->county],
                      ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
              ->whereNull('prescription_filled_status.substitute_presc_id')
             ->first();
             $co22 = DB::table('prescription_filled_status')
                ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                          ['pharmacy.county','=', $region->county],
                          ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
                  ->whereNotNull('prescription_filled_status.substitute_presc_id')
                 ->first();

                   ?>
                       <td>{{($co2->totalq1 + $co22->totalq1)}}</td>
                       <td>{{($co2->total1 + $co22->total1)}}</td>
                       @endif

  @if($Companiez3)
     <?php  $co3 = DB::table('prescription_filled_status')
          ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
          ->join('druglists','druglists.id','=','prescription_details.drug_id')
          ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
          ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
          ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                    ['pharmacy.county','=', $region->county],
                    ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
            ->whereNull('prescription_filled_status.substitute_presc_id')
           ->first();
           $co33 = DB::table('prescription_filled_status')
              ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
              ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
              ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
              ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
              ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                        ['pharmacy.county','=', $region->county],
                        ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
                ->whereNotNull('prescription_filled_status.substitute_presc_id')
               ->first();

                 ?>
                     <td>{{($co3->totalq1 + $co33->totalq1)}}</td>
                     <td>{{($co3->total1 + $co33->total1)}}</td>
        @endif
        @if($Companiez4)
               <?php  $co4 = DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                    ->join('druglists','druglists.id','=','prescription_details.drug_id')
                    ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                    ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                    ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                              ['pharmacy.county','=', $region->county],
                              ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
                      ->whereNull('prescription_filled_status.substitute_presc_id')
                     ->first();
                     $co44 = DB::table('prescription_filled_status')
                        ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                        ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                        ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                                  ['pharmacy.county','=', $region->county],
                                  ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
                          ->whereNotNull('prescription_filled_status.substitute_presc_id')
                         ->first();

                           ?>
                               <td>{{($co4->totalq1 + $co44->totalq1)}}</td>
                               <td>{{($co4->total1 + $co44->total1)}}</td>
                              @endif
@if($Companiez5)
       <?php  $co5 = DB::table('prescription_filled_status')
            ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
            ->join('druglists','druglists.id','=','prescription_details.drug_id')
            ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
            ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
            ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                      ['pharmacy.county','=', $region->county],
                      ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
              ->whereNull('prescription_filled_status.substitute_presc_id')
             ->first();
             $co55 = DB::table('prescription_filled_status')
                ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                          ['pharmacy.county','=', $region->county],
                          ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
                  ->whereNotNull('prescription_filled_status.substitute_presc_id')
                 ->first();

                   ?>
                       <td>{{($co5->totalq1 + $co55->totalq1)}}</td>
                       <td>{{($co5->total1 + $co55->total1)}}</td>
                     </tr>
                     @endif
                  <?php $i++;  ?>
                      @endforeach



                                </tbody>
                            </table>


                             </div>
                          </div>
                         </div>

                   </div>
            </div>
        </div>
        <!--................................. THIS WEEK ...........................-->
        <div id="tab-22a" class="tab-pane">
          <div class="panel-body">
              <div class="ibox float-e-margins">
     <div class="col-md-12">
      <div class="ibox-content">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example" >

            <thead>
          <tr>
           <th>No</th>
           <th>Region</th>


            <th colspan="2">@if($Companiez11){{$Companiez11->Manufacturer}}@endif</th>
           <th colspan="2">@if($Companiez1){{$Companiez1->Manufacturer}}@endif</th>
            <th colspan="2">@if($Companiez2){{$Companiez2->Manufacturer}}@endif</th>
             <th colspan="2">@if($Companiez3){{$Companiez3->Manufacturer}}@endif</th>
             <th colspan="2">@if($Companiez4){{$Companiez4->Manufacturer}}@endif</th>
             <th colspan="2">@if($Companiez5){{$Companiez5->Manufacturer}}@endif</th>


           </tr>
           <tr>
           <th></th>
            <th></th>

            <th>Total Sales</th>
            <th>Value</th>
            <th>Total Sales</th>
            <th>Value</th>
            <th>Total Sales</th>
            <th>Value</th>
            <th>Total Sales</th>
            <th>Value</th>
            <th>Total Sales</th>
            <th>Value</th>
            <th>Total Sales</th>
            <th>Value</th>


            </tr>
           </thead>

        <tbody>



        <?php

        $todaysales = Carbon::today();
        $one_week_ago = Carbon::now()->subWeeks(1);
        $i =1;
        $r1t = DB::table('prescription_filled_status')
        ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
        ->join('druglists','druglists.id','=','prescription_details.drug_id')
        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
        ->select('county as county', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
          ->groupBy('county')
          ->where([
                   ['prescription_filled_status.created_at','>=',$one_week_ago],
                   ['prescription_filled_status.created_at','<=',$todaysales],
                            ])
          ->whereNull('prescription_filled_status.substitute_presc_id')
           ->orderBy('totalq', 'desc')
            ->get();
           ?>
        @foreach($r1t as $region)
        <tr>
        <td>{{$i}}</td>
        <td>{{$region->county}}</td>
        @if($Companiez11)
        <?php  $r1tm = DB::table('prescription_filled_status')
        ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
        ->join('druglists','druglists.id','=','prescription_details.drug_id')
        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
        ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                   ['prescription_filled_status.created_at','<=',$todaysales],
                   ['pharmacy.county','=', $region->county],
                   ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
          ])
        ->whereNull('prescription_filled_status.substitute_presc_id')
        ->first();
        $coms = DB::table('prescription_filled_status')
           ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
           ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
           ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
           ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
           ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                      ['prescription_filled_status.created_at','<=',$todaysales],
                      ['pharmacy.county','=', $region->county],
                      ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
             ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->first();

              ?>

        <td>{{($r1tm->totalq1 + $coms->totalq1)}}</td>
        <td>{{($r1tm->total1 + $coms->total1)}}</td>
      @endif
      @if($Companiez1)
        <?php  $co1 = DB::table('prescription_filled_status')
        ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
        ->join('druglists','druglists.id','=','prescription_details.drug_id')
        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
        ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                   ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
                ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
        ->whereNull('prescription_filled_status.substitute_presc_id')
        ->first();
        $coms1 = DB::table('prescription_filled_status')
           ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
           ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
           ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
           ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
           ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                      ['prescription_filled_status.created_at','<=',$todaysales],
                      ['pharmacy.county','=', $region->county],
                      ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'],
             ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->first();

              ?>

        <td>{{($co1->totalq1 + $coms1->totalq1)}}</td>
        <td>{{($co1->total1 + $coms1->total1)}}</td>
        @endif
        @if($Companiez2)
        <?php  $co2 = DB::table('prescription_filled_status')
        ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
        ->join('druglists','druglists.id','=','prescription_details.drug_id')
        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
        ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                   ['prescription_filled_status.created_at','<=',$todaysales],
        ['pharmacy.county','=', $region->county],
        ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
        ->whereNull('prescription_filled_status.substitute_presc_id')
        ->first();
        $coms2 = DB::table('prescription_filled_status')
           ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
           ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
           ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
           ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
           ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                      ['prescription_filled_status.created_at','<=',$todaysales],
                      ['pharmacy.county','=', $region->county],
                      ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'],
             ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->first();

              ?>

        <td>{{($co2->totalq1 + $coms2->totalq1)}}</td>
        <td>{{($co2->total1 + $coms2->total1)}}</td>
        @endif


  @if($Companiez3)
        <?php  $co3 = DB::table('prescription_filled_status')
        ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
        ->join('druglists','druglists.id','=','prescription_details.drug_id')
        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
        ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                   ['prescription_filled_status.created_at','<=',$todaysales],
        ['pharmacy.county','=', $region->county],
        ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
        ->whereNull('prescription_filled_status.substitute_presc_id')
        ->first();
        $coms3 = DB::table('prescription_filled_status')
           ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
           ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
           ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
           ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
           ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                      ['prescription_filled_status.created_at','<=',$todaysales],
                      ['pharmacy.county','=', $region->county],
                      ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'],
             ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->first();
      ?>
<td>{{($co3->totalq1 + $coms3->totalq1)}}</td>
        <td>{{($co3->total1 + $coms3->total1)}}</td>
@endif
  @if($Companiez4)
        <?php  $co4 = DB::table('prescription_filled_status')
        ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
        ->join('druglists','druglists.id','=','prescription_details.drug_id')
        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
        ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                   ['prescription_filled_status.created_at','<=',$todaysales],
            ['pharmacy.county','=', $region->county],
            ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
        ->whereNull('prescription_filled_status.substitute_presc_id')
        ->first();
        $coms4 = DB::table('prescription_filled_status')
           ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
           ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
           ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
           ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
           ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                      ['prescription_filled_status.created_at','<=',$todaysales],
                      ['pharmacy.county','=', $region->county],
                      ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'],
             ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->first();

              ?>

        <td>{{($co4->totalq1 + $coms4->totalq1)}}</td>
        <td>{{($co4->total1 + $coms4->total1)}}</td>
    @endif
      @if($Companiez5)
        <?php  $co5 = DB::table('prescription_filled_status')
        ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
        ->join('druglists','druglists.id','=','prescription_details.drug_id')
        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
        ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                   ['prescription_filled_status.created_at','<=',$todaysales],
        ['pharmacy.county','=', $region->county],
        ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
        ->whereNull('prescription_filled_status.substitute_presc_id')
        ->first();
        $coms5 = DB::table('prescription_filled_status')
           ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
           ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
           ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
           ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
           ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                      ['prescription_filled_status.created_at','<=',$todaysales],
                      ['pharmacy.county','=', $region->county],
                      ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'],
             ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->first();

              ?>

        <td>{{($co5->totalq1 + $coms5->totalq1)}}</td>
        <td>{{($co5->total1 + $coms5->total1)}}</td>

  </tr>  @endif
        <?php $i++;  ?>
        @endforeach



              </tbody>
          </table>


           </div>
        </div>
        </div>

        </div>
        </div>
        </div>
  <!--................................. THIS MONTH...........................-->
  <div id="tab-23a" class="tab-pane">
        <div class="panel-body">
        <div class="ibox float-e-margins">



       <div class="col-md-12">
      <div class="ibox-content">
        <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-example" >

      <thead>
    <tr>
     <th>No</th>
     <th>Region</th>


      <th colspan="2">@if($Companiez11){{$Companiez11->Manufacturer}}@endif</th>
     <th colspan="2">@if($Companiez1){{$Companiez1->Manufacturer}}@endif</th>
      <th colspan="2">@if($Companiez2){{$Companiez2->Manufacturer}}@endif</th>
       <th colspan="2">@if($Companiez3){{$Companiez3->Manufacturer}}@endif</th>
       <th colspan="2">@if($Companiez4){{$Companiez4->Manufacturer}}@endif</th>
       <th colspan="2">@if($Companiez5){{$Companiez5->Manufacturer}}@endif</th>


     </tr>
     <tr>
     <th></th>
      <th></th>

      <th>Total Sales</th>
      <th>Value</th>
      <th>Total Sales</th>
      <th>Value</th>
      <th>Total Sales</th>
      <th>Value</th>
      <th>Total Sales</th>
      <th>Value</th>
      <th>Total Sales</th>
      <th>Value</th>
      <th>Total Sales</th>
      <th>Value</th>


      </tr>
     </thead>

  <tbody>



  <?php
  $todaysales = Carbon::today();
  $one_month_ago = Carbon::now()->subMonths(1);
  $i =1;
  $r1t = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select('county as county', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
    ->groupBy('county')
    ->where([
             ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
                      ])
    ->whereNull('prescription_filled_status.substitute_presc_id')
     ->orderBy('totalq', 'desc')
      ->get();
     ?>
  @foreach($r1t as $region)
  <tr>
  <td>{{$i}}</td>
  <td>{{$region->county}}</td>
  @if($Companiez11)
  <?php  $r1tm = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
             ['pharmacy.county','=', $region->county],
             ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
    ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $mco = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
                ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

        ?>

  <td>{{($r1tm->totalq1 + $mco->totalq1)}}</td>
  <td>{{($r1tm->total1 + $mco->total1)}}</td>
@endif
@if($Companiez1)
  <?php  $co1 = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
          ['pharmacy.county','=', $region->county],
          ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $mco1 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
                ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

        ?>

  <td>{{($co1->totalq1 + $mco1->totalq1)}}</td>
  <td>{{($co1->total1 + $mco1->total1)}}</td>
  @endif
  @if($Companiez2)
  <?php  $co2 = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','=', $region->county],
  ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $mco2 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
                ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

        ?>

  <td>{{($co2->totalq1 + $mco2->totalq1)}}</td>
  <td>{{($co2->total1 + $mco2->total1)}}</td>
  @endif

  @if($Companiez3)
  <?php  $co3 = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','=', $region->county],
  ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $mco3 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
                ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

        ?>

  <td>{{($co3->totalq1 + $mco3->totalq1)}}</td>
  <td>{{($co3->total1 + $mco3->total1)}}</td>
@endif
  @if($Companiez4)
  <?php  $co4 = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
      ['pharmacy.county','=', $region->county],
      ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $mco4 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
                ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

        ?>

  <td>{{($co4->totalq1 + $mco4->totalq1)}}</td>
  <td>{{($co4->total1 + $mco4->total1)}}</td>
@endif
  @if($Companiez5)
  <?php  $co5 = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','=', $region->county],
  ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $mco5 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
                ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

        ?>

  <td>{{($co5->totalq1 + $mco5->totalq1)}}</td>
  <td>{{($co5->total1 + $mco5->total1)}}</td>
  @endif
</tr>
  <?php $i++;  ?>
  @endforeach



        </tbody>
    </table>


     </div>
  </div>
  </div>

  </div>
  </div>
  </div>

  <!--................................. THIS YEAR...........................-->
  <div id="tab-24a" class="tab-pane">
        <div class="panel-body">
        <div class="ibox float-e-margins">



       <div class="col-md-12">
      <div class="ibox-content">
        <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-example" >

      <thead>
    <tr>
     <th>No</th>
     <th>Region</th>

      <th colspan="2">@if($Companiez11){{$Companiez11->Manufacturer}}@endif</th>
     <th colspan="2">@if($Companiez1){{$Companiez1->Manufacturer}}@endif</th>
      <th colspan="2">@if($Companiez2){{$Companiez2->Manufacturer}}@endif</th>
       <th colspan="2">@if($Companiez3){{$Companiez3->Manufacturer}}@endif</th>
       <th colspan="2">@if($Companiez4){{$Companiez4->Manufacturer}}@endif</th>
       <th colspan="2">@if($Companiez5){{$Companiez5->Manufacturer}}@endif</th>


     </tr>
     <tr>
     <th></th>
      <th></th>

      <th>Total Sales</th>
      <th>Value</th>
      <th>Total Sales</th>
      <th>Value</th>
      <th>Total Sales</th>
      <th>Value</th>
      <th>Total Sales</th>
      <th>Value</th>
      <th>Total Sales</th>
      <th>Value</th>
      <th>Total Sales</th>
      <th>Value</th>


      </tr>
     </thead>

  <tbody>



  <?php

  $todaysales = Carbon::today();
  $one_year_ago = Carbon::now()->subYears(1);
  $i =1;
  $r1t = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select('county as county', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
    ->groupBy('county')
    ->where([
             ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
                      ])
    ->whereNull('prescription_filled_status.substitute_presc_id')
     ->orderBy('totalq', 'desc')
      ->get();
     ?>
  @foreach($r1t as $region)
  <tr>
  <td>{{$i}}</td>
  <td>{{$region->county}}</td>
  @if($Companiez11)
  <?php  $r1ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
             ['pharmacy.county','=', $region->county],
             ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
    ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco1 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
                ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

        ?>

  <td>{{($r1ty->totalq1 + $yco1->totalq1)}}</td>
  <td>{{($r1ty->total1 + $yco1->total1)}}</td>
@endif
@if($Companiez1)
  <?php  $r2ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
          ['pharmacy.county','=', $region->county],
          ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco1 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
                ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

        ?>

  <td>{{($r2ty->totalq1 + $yco1->totalq1)}}</td>
  <td>{{($r2ty->total1 + $yco1->total1)}}</td>
  @endif
  @if($Companiez2)
  <?php  $r3ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','=', $region->county],
  ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco2 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
                ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

        ?>

  <td>{{($r3ty->totalq1 + $yco2->totalq1)}}</td>
  <td>{{($r3ty->total1 + $yco2->total1)}}</td>
  @endif

  @if($Companiez3)
  <?php  $r4ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','=', $region->county],
  ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco3 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
                ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

        ?>

  <td>{{($r4ty->totalq1 + $yco3->totalq1)}}</td>
  <td>{{($r4ty->total1 + $yco3->total1)}}</td>
  @endif
  @if($Companiez4)
  <?php  $r5ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
      ['pharmacy.county','=', $region->county],
      ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco4 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
                ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

        ?>

  <td>{{($r5ty->totalq1 + $yco4->totalq1)}}</td>
  <td>{{($r5ty->total1 + $yco4->total1)}}</td>
@endif
@if($Companiez5)
  <?php  $r6ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','=', $region->county],
  ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();

  $yco5 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
                ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

        ?>

  <td>{{($r6ty->totalq1 + $yco5->totalq1)}}</td>
  <td>{{($r6ty->total1 + $yco5->total1)}}</td>  </tr>
  @endif
  <?php $i++;  ?>
  @endforeach



        </tbody>
    </table>


     </div>
  </div>
  </div>

  </div>
  </div>
  </div>
<!--................................. MAX ...........................-->

<div id="tab-25a" class="tab-pane">
      <div class="panel-body">
      <div class="ibox float-e-margins">



     <div class="col-md-12">
    <div class="ibox-content">
      <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover dataTables-example" >

    <thead>
  <tr>
   <th>No</th>
   <th>Region</th>



    <th colspan="2">@if($Companiez11){{$Companiez11->Manufacturer}}@endif</th>
   <th colspan="2">@if($Companiez1){{$Companiez1->Manufacturer}}@endif</th>
    <th colspan="2">@if($Companiez2){{$Companiez2->Manufacturer}}@endif</th>
     <th colspan="2">@if($Companiez3){{$Companiez3->Manufacturer}}@endif</th>
     <th colspan="2">@if($Companiez4){{$Companiez4->Manufacturer}}@endif</th>
     <th colspan="2">@if($Companiez5){{$Companiez5->Manufacturer}}@endif</th>

   </tr>
   <tr>
   <th></th>
    <th></th>

    <th>Total Sales</th>
    <th>Value</th>
    <th>Total Sales</th>
    <th>Value</th>
    <th>Total Sales</th>
    <th>Value</th>
    <th>Total Sales</th>
    <th>Value</th>
    <th>Total Sales</th>
    <th>Value</th>
    <th>Total Sales</th>
    <th>Value</th>


    </tr>
   </thead>

<tbody>



<?php


$i =1;
$r1t = DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
->select('county as county', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
  ->groupBy('county')

  ->whereNull('prescription_filled_status.substitute_presc_id')
   ->orderBy('totalq', 'desc')
    ->get();
   ?>
@foreach($r1t as $region)
<tr>
<td>{{$i}}</td>
<td>{{$region->county}}</td>
@if($Companiez11)
<?php  $rall1 = DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
->where([
           ['pharmacy.county','=', $region->county],
           ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
  ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
$sall1 = DB::table('prescription_filled_status')
   ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
   ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
   ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
   ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
   ->where([
              ['pharmacy.county','=', $region->county],
              ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
     ])
     ->whereNotNull('prescription_filled_status.substitute_presc_id')
    ->first();

      ?>

<td>{{($rall1->totalq1 + $sall1->totalq1)}}</td>
<td>{{($rall1->total1 + $sall1->total1)}}</td>
 @endif
 @if($Companiez1)
<?php  $rall2 = DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
->where([
        ['pharmacy.county','=', $region->county],
        ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
$sall2 = DB::table('prescription_filled_status')
   ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
   ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
   ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
   ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
   ->where([
              ['pharmacy.county','=', $region->county],
              ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'],
     ])
     ->whereNotNull('prescription_filled_status.substitute_presc_id')
    ->first();

      ?>

<td>{{($rall2->totalq1 + $sall2->totalq1)}}</td>
<td>{{($rall2->total1 + $sall2->total1)}}</td>
@endif
@if($Companiez2)
<?php  $rall3 = DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
->where([
['pharmacy.county','=', $region->county],
['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
$sall3 = DB::table('prescription_filled_status')
   ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
   ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
   ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
   ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
   ->where([
              ['pharmacy.county','=', $region->county],
              ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'],
     ])
     ->whereNotNull('prescription_filled_status.substitute_presc_id')
    ->first();

      ?>

<td>{{($rall3->totalq1 + $sall3->totalq1)}}</td>
<td>{{($rall3->total1 + $sall3->total1)}}</td>
@endif

  @if($Companiez3)
<?php  $rall4 = DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
->where([
['pharmacy.county','=', $region->county],
['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
$sall4 = DB::table('prescription_filled_status')
   ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
   ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
   ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
   ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
   ->where([
              ['pharmacy.county','=', $region->county],
              ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'],
     ])
     ->whereNotNull('prescription_filled_status.substitute_presc_id')
    ->first();

      ?>

<td>{{($rall4->totalq1 + $sall4->totalq1)}}</td>
<td>{{($rall4->total1 + $sall4->total1)}}</td>
@endif
  @if($Companiez4)
<?php  $rall5 = DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
->where([
    ['pharmacy.county','=', $region->county],
    ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
$sall5 = DB::table('prescription_filled_status')
   ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
   ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
   ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
   ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
   ->where([
              ['pharmacy.county','=', $region->county],
              ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'],
     ])
     ->whereNotNull('prescription_filled_status.substitute_presc_id')
    ->first();

      ?>

<td>{{($rall5->totalq1 + $sall5->totalq1)}}</td>
<td>{{($rall5->total1 + $sall5->total1)}}</td>
  @endif
  @if($Companiez5)
<?php  $rall6 = DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
->where([
['pharmacy.county','=', $region->county],
['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
$sall6 = DB::table('prescription_filled_status')
   ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
   ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
   ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
   ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
   ->where([
              ['pharmacy.county','=', $region->county],
              ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'],
     ])
     ->whereNotNull('prescription_filled_status.substitute_presc_id')
    ->first();

      ?>

<td>{{($rall6->totalq1 + $sall6->totalq1)}}</td>
<td>{{($rall6->total1 + $sall6->total1)}}</td>

</tr>
@endif
<?php $i++;  ?>
@endforeach



      </tbody>
  </table>


   </div>
</div>
</div>

</div>
</div>
</div>
<!--................................. CUSTOM ...........................-->

<!--................................. CUSTOM ...........................-->


                              </div>
                            </div>
