 <div id="tab-4" class="tab-pane">
                             <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-41a">Today</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-42a">This Week</a></li>
                             <li class=""><a data-toggle="tab" href="#tab-43a">This Month</a></li>
                          <li class=""><a data-toggle="tab" href="#tab-44a">This Year</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-45a">Max</a></li>
                             <li class=""><a data-toggle="tab" href="#tab-46a">Custom</a></li>
                        </ul>
                        <br>
                        <div class="tab-content">
<div id="tab-41a" class="tab-pane active">
    <div class="panel-body">
      <div class="ibox float-e-margins">
         <div class="col-md-12">
              <div class="ibox-content">
                <?php
                use Carbon\Carbon;
                $today = Carbon::today();
                $one_week_ago = Carbon::now()->subWeeks(1);
                $one_month_ago = Carbon::now()->subMonths(1);
                $one_year_ago = Carbon::now()->subYears(1);

                $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();
         ?>
  @foreach($Drugt as $drt)
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
              <tr>
                <th>No</th>
                <th>Drug Name</th>
                <th colspan="2">DIRECT SALES</th>
                <th colspan="2">SUBSTITUTED SALES</th>
                <th colspan="2">TOTAL Sales</th>
              </tr>
              <tr>
                <th></th>
                <th></th>
                <th>Units</th>
                <th>Value</th>
                <th>Units</th>
                <th>Value</th>
                <th colspan="2">#</th>
              </tr>
            </thead>
            <tbody>


                <tr>
                 <?php  $Drug1 = DB::table('druglists')->where('id','>=',$drt->company )->first();
                  $drugsum=DB::table('prescription_filled_status')
                  ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                  ->select('prescription_filled_status.price as dprice')
                  ->selectRaw('SUM(quantity) as quantity')
                  ->selectRaw('SUM(price*quantity) as qprice')
                  ->where([  ['prescription_filled_status.created_at','>=',$today],
                             ['prescription_details.drug_id','=',$drt->company], ])
                  ->whereNull('prescription_filled_status.substitute_presc_id')
                  ->first();

                  $subdrugsum=DB::table('prescription_filled_status')
                  ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                  ->select('prescription_filled_status.price as dprice')
                  ->selectRaw('SUM(quantity) as quantity')
                  ->selectRaw('SUM(price*quantity) as qprice')
                  ->where([   ['prescription_filled_status.created_at','>=',$today],
                             ['substitute_presc_details.drug_id','=',$drt->company], ])
                  ->whereNotNull('prescription_filled_status.substitute_presc_id')
                  ->first();
                  ?>
                  <td>1</td>
                  <td>{{$Drug1->drugname}}</td>
                  <td>{{$drugsum->quantity}}</td>
                  <td>{{$drugsum->qprice}}</td>
                  <td>{{$subdrugsum->quantity}}</td>
                  <td>{{$subdrugsum->qprice}}</td>
                  <td colspan="2">{{($drugsum->qprice + $subdrugsum->qprice)}}</td>

               </tr>
              <tr>
                <?php  $Drug2 = DB::table('druglists')->where('id','>=',$drt->competition_1 )->first();
                $drugsum1=DB::table('prescription_filled_status')
                ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                ->select('prescription_filled_status.price as dprice')
                ->selectRaw('SUM(quantity) as quantity')
                ->selectRaw('SUM(price*quantity) as qprice')
                ->where([  ['prescription_filled_status.created_at','>=',$today],
                           ['prescription_details.drug_id','=',$drt->competition_1], ])
                ->whereNull('prescription_filled_status.substitute_presc_id')
                ->first();

                $subdrugsum1=DB::table('prescription_filled_status')
                ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                ->select('prescription_filled_status.price as dprice')
                ->selectRaw('SUM(quantity) as quantity')
                ->selectRaw('SUM(price*quantity) as qprice')
                ->where([  ['prescription_filled_status.created_at','>=',$today],
                           ['substitute_presc_details.drug_id','=',$drt->competition_1], ])
                ->whereNotNull('prescription_filled_status.substitute_presc_id')
                ->first();
                ?>
                <td>2</td>
                <td>{{$Drug2->drugname}}</td>
                <td>{{$drugsum1->quantity}}</td>
                <td>{{$drugsum1->qprice}}</td>
                <td>{{$subdrugsum1->quantity}}</td>
                <td>{{$subdrugsum1->qprice}}</td>
                <td colspan="2">{{($drugsum1->qprice + $subdrugsum1->qprice)}}</td>
             </tr>
             <tr>
               <?php  $Drug3 = DB::table('druglists')->where('id','>=',$drt->competition_2 )->first();
               $drugsum2=DB::table('prescription_filled_status')
               ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
               ->select('prescription_filled_status.price as dprice')
               ->selectRaw('SUM(quantity) as quantity')
               ->selectRaw('SUM(price*quantity) as qprice')
               ->where([  ['prescription_filled_status.created_at','>=',$today],
                          ['prescription_details.drug_id','=',$drt->competition_2], ])
               ->whereNull('prescription_filled_status.substitute_presc_id')
               ->first();

               $subdrugsum2=DB::table('prescription_filled_status')
               ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
               ->select('prescription_filled_status.price as dprice')
               ->selectRaw('SUM(quantity) as quantity')
               ->selectRaw('SUM(price*quantity) as qprice')
               ->where([  ['prescription_filled_status.created_at','>=',$today],
                          ['substitute_presc_details.drug_id','=',$drt->competition_2], ])
               ->whereNotNull('prescription_filled_status.substitute_presc_id')
               ->first();
               ?>
               <td>3</td>
               <td>{{$Drug3->drugname}}</td>
               <td>{{$drugsum2->quantity}}</td>
               <td>{{$drugsum2->qprice}}</td>
               <td>{{$subdrugsum2->quantity}}</td>
               <td>{{$subdrugsum2->qprice}}</td>
               <td colspan="2">{{($drugsum2->qprice + $subdrugsum2->qprice)}}</td>
            </tr>
            <tr>
              <?php  $Drug4 = DB::table('druglists')->where('id','>=',$drt->competition_3 )->first();
              $drugsum3=DB::table('prescription_filled_status')
              ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
              ->select('prescription_filled_status.price as dprice')
              ->selectRaw('SUM(quantity) as quantity')
              ->selectRaw('SUM(price*quantity) as qprice')
              ->where([  ['prescription_filled_status.created_at','>=',$today],
                         ['prescription_details.drug_id','=',$drt->competition_3], ])
              ->whereNull('prescription_filled_status.substitute_presc_id')
              ->first();

              $subdrugsum3=DB::table('prescription_filled_status')
              ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
              ->select('prescription_filled_status.price as dprice')
              ->selectRaw('SUM(quantity) as quantity')
              ->selectRaw('SUM(price*quantity) as qprice')
              ->where([  ['prescription_filled_status.created_at','>=',$today],
                         ['substitute_presc_details.drug_id','=',$drt->competition_3], ])
              ->whereNotNull('prescription_filled_status.substitute_presc_id')
              ->first();
               ?>
              <td>4</td>
              <td>{{$Drug4->drugname}}</td>
              <td>{{$drugsum3->quantity}}</td>
              <td>{{$drugsum3->qprice}}</td>
              <td>{{$subdrugsum3->quantity}}</td>
              <td>{{$subdrugsum3->qprice}}</td>
              <td colspan="2">{{($drugsum3->qprice + $subdrugsum3->qprice)}}</td>
           </tr>
           <tr>
             <?php  $Drug5 = DB::table('druglists')->where('id','>=',$drt->competition_4 )->first();
             $drugsum4=DB::table('prescription_filled_status')
             ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
             ->select('prescription_filled_status.price as dprice')
             ->selectRaw('SUM(quantity) as quantity')
             ->selectRaw('SUM(price*quantity) as qprice')
             ->where([  ['prescription_filled_status.created_at','>=',$today],
                        ['prescription_details.drug_id','=',$drt->competition_4], ])
             ->whereNull('prescription_filled_status.substitute_presc_id')
             ->first();

             $subdrugsum4=DB::table('prescription_filled_status')
             ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
             ->select('prescription_filled_status.price as dprice')
             ->selectRaw('SUM(quantity) as quantity')
             ->selectRaw('SUM(price*quantity) as qprice')
             ->where([  ['prescription_filled_status.created_at','>=',$today],
                        ['substitute_presc_details.drug_id','=',$drt->competition_4], ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
             ->first();
             ?>
             <td>5</td>
             <td>{{$Drug5->drugname}}</td>
             <td>{{$drugsum4->quantity}}</td>
             <td>{{$drugsum4->qprice}}</td>
             <td>{{$subdrugsum4->quantity}}</td>
             <td>{{$subdrugsum4->qprice}}</td>
             <td colspan="2">{{($drugsum4->qprice + $subdrugsum4->qprice)}}</td>
          </tr>
          <tr>
            <?php  $Drug6 = DB::table('druglists')->where('id','>=',$drt->competition_5 )->first();
            $drugsum5=DB::table('prescription_filled_status')
            ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
            ->select('prescription_filled_status.price as dprice')
            ->selectRaw('SUM(quantity) as quantity')
            ->selectRaw('SUM(price*quantity) as qprice')
            ->where([  ['prescription_filled_status.created_at','>=',$today],
                       ['prescription_details.drug_id','=',$drt->competition_5], ])
            ->whereNull('prescription_filled_status.substitute_presc_id')
            ->first();

            $subdrugsum5=DB::table('prescription_filled_status')
            ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
            ->select('prescription_filled_status.price as dprice')
            ->selectRaw('SUM(quantity) as quantity')
            ->selectRaw('SUM(price*quantity) as qprice')
            ->where([  ['prescription_filled_status.created_at','>=',$today],
                       ['substitute_presc_details.drug_id','=',$drt->competition_5], ])
            ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->first();
            ?>
            <td>6</td>
            <td>{{$Drug6->drugname}}</td>
            <td>{{$drugsum5->quantity}}</td>
            <td>{{$drugsum5->qprice}}</td>
            <td>{{$subdrugsum5->quantity}}</td>
            <td>{{$subdrugsum5->qprice}}</td>
            <td colspan="2">{{($drugsum5->qprice + $subdrugsum5->qprice)}}</td>
         </tr>


                               </tbody>
                            </table>
                        </div>
                        @endforeach
                      </div>
                   </div>
               </div>
            </div>
        </div>
  <!--................................. THIS WEEK ...........................-->
  <div id="tab-42a" class="tab-pane">
      <div class="panel-body">
        <div class="ibox float-e-margins">
           <div class="col-md-12">
                <div class="ibox-content">
                  <?php

                $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();
           ?>
    @foreach($Drugw as $drt)
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Drug Name</th>
                  <th colspan="2">DIRECT SALES</th>
                  <th colspan="2">SUBSTITUTED SALES</th>
                  <th colspan="2">TOTAL Sales</th>
                </tr>
                <tr>
                  <th></th>
                  <th></th>
                  <th>Units</th>
                  <th>Value</th>
                  <th>Units</th>
                  <th>Value</th>
                  <th colspan="2">#</th>
                </tr>
              </thead>
              <tbody>


                  <tr>
                   <?php  $Drugw1 = DB::table('druglists')->where('id','>=',$drt->company )->first();
                    $drugsumw=DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                    ->select('prescription_filled_status.price as dprice')
                    ->selectRaw('SUM(quantity) as quantity')
                    ->selectRaw('SUM(price*quantity) as qprice')
                    ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                    ['prescription_filled_status.created_at','<=',$today],
                               ['prescription_details.drug_id','=',$drt->company], ])
                    ->whereNull('prescription_filled_status.substitute_presc_id')
                    ->first();

                    $subdrugsumw=DB::table('prescription_filled_status')
                    ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                    ->select('prescription_filled_status.price as dprice')
                    ->selectRaw('SUM(quantity) as quantity')
                    ->selectRaw('SUM(price*quantity) as qprice')
                    ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                    ['prescription_filled_status.created_at','<=',$today],
                               ['substitute_presc_details.drug_id','=',$drt->company], ])
                    ->whereNotNull('prescription_filled_status.substitute_presc_id')
                    ->first();
                    ?>
                    <td>1</td>
                    <td>{{$Drugw1->drugname}}</td>
                    <td>{{$drugsumw->quantity}}</td>
                    <td>{{$drugsumw->qprice}}</td>
                    <td>{{$subdrugsumw->quantity}}</td>
                    <td>{{$subdrugsumw->qprice}}</td>
                    <td colspan="2">{{($drugsumw->qprice + $subdrugsumw->qprice)}}</td>

                 </tr>
                <tr>
                  <?php  $Drugw2 = DB::table('druglists')->where('id','>=',$drt->competition_1 )->first();
                  $drugsumw1=DB::table('prescription_filled_status')
                  ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                  ->select('prescription_filled_status.price as dprice')
                  ->selectRaw('SUM(quantity) as quantity')
                  ->selectRaw('SUM(price*quantity) as qprice')
                  ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                  ['prescription_filled_status.created_at','<=',$today],
                             ['prescription_details.drug_id','=',$drt->competition_1], ])
                  ->whereNull('prescription_filled_status.substitute_presc_id')
                  ->first();

                  $subdrugsumw1=DB::table('prescription_filled_status')
                  ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                  ->select('prescription_filled_status.price as dprice')
                  ->selectRaw('SUM(quantity) as quantity')
                  ->selectRaw('SUM(price*quantity) as qprice')
                  ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                            ['prescription_filled_status.created_at','<=',$today],
                             ['substitute_presc_details.drug_id','=',$drt->competition_1], ])
                  ->whereNotNull('prescription_filled_status.substitute_presc_id')
                  ->first();
                  ?>
                  <td>2</td>
                  <td>{{$Drugw2->drugname}}</td>
                  <td>{{$drugsumw1->quantity}}</td>
                  <td>{{$drugsumw1->qprice}}</td>
                  <td>{{$subdrugsumw1->quantity}}</td>
                  <td>{{$subdrugsumw1->qprice}}</td>
                  <td colspan="2">{{($drugsumw1->qprice + $subdrugsumw1->qprice)}}</td>
               </tr>
               <tr>
                 <?php  $Drugw3 = DB::table('druglists')->where('id','>=',$drt->competition_2 )->first();
                 $drugsumw2=DB::table('prescription_filled_status')
                 ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                 ->select('prescription_filled_status.price as dprice')
                 ->selectRaw('SUM(quantity) as quantity')
                 ->selectRaw('SUM(price*quantity) as qprice')
                 ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                           ['prescription_filled_status.created_at','<=',$today],
                            ['prescription_details.drug_id','=',$drt->competition_2], ])
                 ->whereNull('prescription_filled_status.substitute_presc_id')
                 ->first();

                 $subdrugsumw2=DB::table('prescription_filled_status')
                 ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                 ->select('prescription_filled_status.price as dprice')
                 ->selectRaw('SUM(quantity) as quantity')
                 ->selectRaw('SUM(price*quantity) as qprice')
                 ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                           ['prescription_filled_status.created_at','<=',$today],
                            ['substitute_presc_details.drug_id','=',$drt->competition_2], ])
                 ->whereNotNull('prescription_filled_status.substitute_presc_id')
                 ->first();
                 ?>
                 <td>3</td>
                 <td>{{$Drugw3->drugname}}</td>
                 <td>{{$drugsumw2->quantity}}</td>
                 <td>{{$drugsumw2->qprice}}</td>
                 <td>{{$subdrugsumw2->quantity}}</td>
                 <td>{{$subdrugsumw2->qprice}}</td>
                 <td colspan="2">{{($drugsumw2->qprice + $subdrugsumw2->qprice)}}</td>
              </tr>
              <tr>
                <?php  $Drugw4 = DB::table('druglists')->where('id','>=',$drt->competition_3 )->first();
                $drugsumw3=DB::table('prescription_filled_status')
                ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                ->select('prescription_filled_status.price as dprice')
                ->selectRaw('SUM(quantity) as quantity')
                ->selectRaw('SUM(price*quantity) as qprice')
                ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                           ['prescription_filled_status.created_at','<=',$today],
                           ['prescription_details.drug_id','=',$drt->competition_3], ])
                ->whereNull('prescription_filled_status.substitute_presc_id')
                ->first();

                $subdrugsumw3=DB::table('prescription_filled_status')
                ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                ->select('prescription_filled_status.price as dprice')
                ->selectRaw('SUM(quantity) as quantity')
                ->selectRaw('SUM(price*quantity) as qprice')
                ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                           ['prescription_filled_status.created_at','<=',$today],
                           ['substitute_presc_details.drug_id','=',$drt->competition_3], ])
                ->whereNotNull('prescription_filled_status.substitute_presc_id')
                ->first();
                 ?>
                <td>4</td>
                <td>{{$Drugw4->drugname}}</td>
                <td>{{$drugsumw3->quantity}}</td>
                <td>{{$drugsumw3->qprice}}</td>
                <td>{{$subdrugsumw3->quantity}}</td>
                <td>{{$subdrugsumw3->qprice}}</td>
                <td colspan="2">{{($drugsumw3->qprice + $subdrugsumw3->qprice)}}</td>
             </tr>
             <tr>
               <?php  $Drugw5 = DB::table('druglists')->where('id','>=',$drt->competition_4 )->first();
               $drugsumw4=DB::table('prescription_filled_status')
               ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
               ->select('prescription_filled_status.price as dprice')
               ->selectRaw('SUM(quantity) as quantity')
               ->selectRaw('SUM(price*quantity) as qprice')
               ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                           ['prescription_filled_status.created_at','<=',$today],
                          ['prescription_details.drug_id','=',$drt->competition_4], ])
               ->whereNull('prescription_filled_status.substitute_presc_id')
               ->first();

               $subdrugsumw4=DB::table('prescription_filled_status')
               ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
               ->select('prescription_filled_status.price as dprice')
               ->selectRaw('SUM(quantity) as quantity')
               ->selectRaw('SUM(price*quantity) as qprice')
               ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                          ['prescription_filled_status.created_at','<=',$today],
                          ['substitute_presc_details.drug_id','=',$drt->competition_4], ])
               ->whereNotNull('prescription_filled_status.substitute_presc_id')
               ->first();
               ?>
               <td>5</td>
               <td>{{$Drugw5->drugname}}</td>
               <td>{{$drugsumw4->quantity}}</td>
               <td>{{$drugsumw4->qprice}}</td>
               <td>{{$subdrugsumw4->quantity}}</td>
               <td>{{$subdrugsumw4->qprice}}</td>
               <td colspan="2">{{($drugsumw4->qprice + $subdrugsumw4->qprice)}}</td>
            </tr>
            <tr>
              <?php  $Drugw6 = DB::table('druglists')->where('id','>=',$drt->competition_5 )->first();
              $drugsumw5=DB::table('prescription_filled_status')
              ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
              ->select('prescription_filled_status.price as dprice')
              ->selectRaw('SUM(quantity) as quantity')
              ->selectRaw('SUM(price*quantity) as qprice')
              ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
              ['prescription_filled_status.created_at','<=',$today],
                         ['prescription_details.drug_id','=',$drt->competition_5], ])
              ->whereNull('prescription_filled_status.substitute_presc_id')
              ->first();

              $subdrugsumw5=DB::table('prescription_filled_status')
              ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
              ->select('prescription_filled_status.price as dprice')
              ->selectRaw('SUM(quantity) as quantity')
              ->selectRaw('SUM(price*quantity) as qprice')
              ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
              ['prescription_filled_status.created_at','<=',$today],
                         ['substitute_presc_details.drug_id','=',$drt->competition_5], ])
              ->whereNotNull('prescription_filled_status.substitute_presc_id')
              ->first();
              ?>
              <td>6</td>
              <td>{{$Drugw6->drugname}}</td>
              <td>{{$drugsumw5->quantity}}</td>
              <td>{{$drugsumw5->qprice}}</td>
              <td>{{$subdrugsumw5->quantity}}</td>
              <td>{{$subdrugsumw5->qprice}}</td>
              <td colspan="2">{{($drugsumw5->qprice + $subdrugsumw5->qprice)}}</td>
           </tr>


                                 </tbody>
                              </table>
                          </div>
                          @endforeach
                        </div>
                     </div>
                 </div>
              </div>
          </div>

  <!--................................. THIS MONTH...........................-->
  <div id="tab-43a" class="tab-pane">
      <div class="panel-body">
        <div class="ibox float-e-margins">
           <div class="col-md-12">
                <div class="ibox-content">
                  <?php

                $Drugm = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();
           ?>
    @foreach($Drugm as $drt)
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Drug Name</th>
                  <th colspan="2">DIRECT SALES</th>
                  <th colspan="2">SUBSTITUTED SALES</th>
                  <th colspan="2">TOTAL Sales</th>
                </tr>
                <tr>
                  <th></th>
                  <th></th>
                  <th>Units</th>
                  <th>Value</th>
                  <th>Units</th>
                  <th>Value</th>
                  <th colspan="2">#</th>
                </tr>
              </thead>
              <tbody>


                  <tr>
                   <?php  $Drugm1 = DB::table('druglists')->where('id','>=',$drt->company )->first();
                    $drugsumm=DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                    ->select('prescription_filled_status.price as dprice')
                    ->selectRaw('SUM(quantity) as quantity')
                    ->selectRaw('SUM(price*quantity) as qprice')
                    ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
                    ['prescription_filled_status.created_at','<=',$today],
                               ['prescription_details.drug_id','=',$drt->company], ])
                    ->whereNull('prescription_filled_status.substitute_presc_id')
                    ->first();

                    $subdrugsumm=DB::table('prescription_filled_status')
                    ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                    ->select('prescription_filled_status.price as dprice')
                    ->selectRaw('SUM(quantity) as quantity')
                    ->selectRaw('SUM(price*quantity) as qprice')
                    ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
                    ['prescription_filled_status.created_at','<=',$today],
                               ['substitute_presc_details.drug_id','=',$drt->company], ])
                    ->whereNotNull('prescription_filled_status.substitute_presc_id')
                    ->first();
                    ?>
                    <td>1</td>
                    <td>{{$Drugm1->drugname}}</td>
                    <td>{{$drugsumm->quantity}}</td>
                    <td>{{$drugsumm->qprice}}</td>
                    <td>{{$subdrugsumm->quantity}}</td>
                    <td>{{$subdrugsumm->qprice}}</td>
                    <td colspan="2">{{($drugsumm->qprice + $subdrugsumm->qprice)}}</td>

                 </tr>
                <tr>
                  <?php  $Drugm2 = DB::table('druglists')->where('id','>=',$drt->competition_1 )->first();
                  $drugsumm1=DB::table('prescription_filled_status')
                  ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                  ->select('prescription_filled_status.price as dprice')
                  ->selectRaw('SUM(quantity) as quantity')
                  ->selectRaw('SUM(price*quantity) as qprice')
                  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
                  ['prescription_filled_status.created_at','<=',$today],
                             ['prescription_details.drug_id','=',$drt->competition_1], ])
                  ->whereNull('prescription_filled_status.substitute_presc_id')
                  ->first();

                  $subdrugsumm1=DB::table('prescription_filled_status')
                  ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                  ->select('prescription_filled_status.price as dprice')
                  ->selectRaw('SUM(quantity) as quantity')
                  ->selectRaw('SUM(price*quantity) as qprice')
                  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
                            ['prescription_filled_status.created_at','<=',$today],
                             ['substitute_presc_details.drug_id','=',$drt->competition_1], ])
                  ->whereNotNull('prescription_filled_status.substitute_presc_id')
                  ->first();
                  ?>
                  <td>2</td>
                  <td>{{$Drugm2->drugname}}</td>
                  <td>{{$drugsumm1->quantity}}</td>
                  <td>{{$drugsumm1->qprice}}</td>
                  <td>{{$subdrugsumm1->quantity}}</td>
                  <td>{{$subdrugsumm1->qprice}}</td>
                  <td colspan="2">{{($drugsumm1->qprice + $subdrugsumm1->qprice)}}</td>
               </tr>
               <tr>
                 <?php  $Drugm3 = DB::table('druglists')->where('id','>=',$drt->competition_2 )->first();
                 $drugsumm2=DB::table('prescription_filled_status')
                 ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                 ->select('prescription_filled_status.price as dprice')
                 ->selectRaw('SUM(quantity) as quantity')
                 ->selectRaw('SUM(price*quantity) as qprice')
                 ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
                           ['prescription_filled_status.created_at','<=',$today],
                            ['prescription_details.drug_id','=',$drt->competition_2], ])
                 ->whereNull('prescription_filled_status.substitute_presc_id')
                 ->first();

                 $subdrugsumm2=DB::table('prescription_filled_status')
                 ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                 ->select('prescription_filled_status.price as dprice')
                 ->selectRaw('SUM(quantity) as quantity')
                 ->selectRaw('SUM(price*quantity) as qprice')
                 ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
                           ['prescription_filled_status.created_at','<=',$today],
                            ['substitute_presc_details.drug_id','=',$drt->competition_2], ])
                 ->whereNotNull('prescription_filled_status.substitute_presc_id')
                 ->first();
                 ?>
                 <td>3</td>
                 <td>{{$Drugm3->drugname}}</td>
                 <td>{{$drugsumm2->quantity}}</td>
                 <td>{{$drugsumm2->qprice}}</td>
                 <td>{{$subdrugsumm2->quantity}}</td>
                 <td>{{$subdrugsumm2->qprice}}</td>
                 <td colspan="2">{{($drugsumm2->qprice + $subdrugsumm2->qprice)}}</td>
              </tr>
              <tr>
                <?php  $Drugm4 = DB::table('druglists')->where('id','>=',$drt->competition_3 )->first();
                $drugsumm3=DB::table('prescription_filled_status')
                ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                ->select('prescription_filled_status.price as dprice')
                ->selectRaw('SUM(quantity) as quantity')
                ->selectRaw('SUM(price*quantity) as qprice')
                ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                           ['prescription_filled_status.created_at','<=',$today],
                           ['prescription_details.drug_id','=',$drt->competition_3], ])
                ->whereNull('prescription_filled_status.substitute_presc_id')
                ->first();

                $subdrugsumm3=DB::table('prescription_filled_status')
                ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                ->select('prescription_filled_status.price as dprice')
                ->selectRaw('SUM(quantity) as quantity')
                ->selectRaw('SUM(price*quantity) as qprice')
                ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                           ['prescription_filled_status.created_at','<=',$today],
                           ['substitute_presc_details.drug_id','=',$drt->competition_3], ])
                ->whereNotNull('prescription_filled_status.substitute_presc_id')
                ->first();
                 ?>
                <td>4</td>
                <td>{{$Drugm4->drugname}}</td>
                <td>{{$drugsumm3->quantity}}</td>
                <td>{{$drugsumm3->qprice}}</td>
                <td>{{$subdrugsumm3->quantity}}</td>
                <td>{{$subdrugsumm3->qprice}}</td>
                <td colspan="2">{{($drugsumm3->qprice + $subdrugsumm3->qprice)}}</td>
             </tr>
             <tr>
               <?php  $Drugm5 = DB::table('druglists')->where('id','>=',$drt->competition_4 )->first();
               $drugsumm4=DB::table('prescription_filled_status')
               ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
               ->select('prescription_filled_status.price as dprice')
               ->selectRaw('SUM(quantity) as quantity')
               ->selectRaw('SUM(price*quantity) as qprice')
               ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                           ['prescription_filled_status.created_at','<=',$today],
                          ['prescription_details.drug_id','=',$drt->competition_4], ])
               ->whereNull('prescription_filled_status.substitute_presc_id')
               ->first();

               $subdrugsumm4=DB::table('prescription_filled_status')
               ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
               ->select('prescription_filled_status.price as dprice')
               ->selectRaw('SUM(quantity) as quantity')
               ->selectRaw('SUM(price*quantity) as qprice')
               ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
                          ['prescription_filled_status.created_at','<=',$today],
                          ['substitute_presc_details.drug_id','=',$drt->competition_4], ])
               ->whereNotNull('prescription_filled_status.substitute_presc_id')
               ->first();
               ?>
               <td>5</td>
               <td>{{$Drugm5->drugname}}</td>
               <td>{{$drugsumm4->quantity}}</td>
               <td>{{$drugsumm4->qprice}}</td>
               <td>{{$subdrugsumm4->quantity}}</td>
               <td>{{$subdrugsumm4->qprice}}</td>
               <td colspan="2">{{($drugsumm4->qprice + $subdrugsumm4->qprice)}}</td>
            </tr>
            <tr>
              <?php  $Drugm6 = DB::table('druglists')->where('id','>=',$drt->competition_5 )->first();
              $drugsumm5=DB::table('prescription_filled_status')
              ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
              ->select('prescription_filled_status.price as dprice')
              ->selectRaw('SUM(quantity) as quantity')
              ->selectRaw('SUM(price*quantity) as qprice')
              ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
              ['prescription_filled_status.created_at','<=',$today],
                         ['prescription_details.drug_id','=',$drt->competition_5], ])
              ->whereNull('prescription_filled_status.substitute_presc_id')
              ->first();

              $subdrugsumm5=DB::table('prescription_filled_status')
              ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
              ->select('prescription_filled_status.price as dprice')
              ->selectRaw('SUM(quantity) as quantity')
              ->selectRaw('SUM(price*quantity) as qprice')
              ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
              ['prescription_filled_status.created_at','<=',$today],
                         ['substitute_presc_details.drug_id','=',$drt->competition_5], ])
              ->whereNotNull('prescription_filled_status.substitute_presc_id')
              ->first();
              ?>
              <td>6</td>
              <td>{{$Drugm6->drugname}}</td>
              <td>{{$drugsumm5->quantity}}</td>
              <td>{{$drugsumm5->qprice}}</td>
              <td>{{$subdrugsumm5->quantity}}</td>
              <td>{{$subdrugsumm5->qprice}}</td>
              <td colspan="2">{{($drugsumm5->qprice + $subdrugsumm5->qprice)}}</td>
           </tr>


                                 </tbody>
                              </table>
                          </div>
                          @endforeach
                        </div>
                     </div>
                 </div>
              </div>
          </div>

  <!--................................. THIS YEAR...........................-->

  <div id="tab-44a" class="tab-pane">
      <div class="panel-body">
        <div class="ibox float-e-margins">
           <div class="col-md-12">
                <div class="ibox-content">
                  <?php

                $Drugy = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();
           ?>
    @foreach($Drugy as $drt)
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Drug Name</th>
                  <th colspan="2">DIRECT SALES</th>
                  <th colspan="2">SUBSTITUTED SALES</th>
                  <th colspan="2">TOTAL Sales</th>
                </tr>
                <tr>
                  <th></th>
                  <th></th>
                  <th>Units</th>
                  <th>Value</th>
                  <th>Units</th>
                  <th>Value</th>
                  <th colspan="2">#</th>
                </tr>
              </thead>
              <tbody>


                  <tr>
                   <?php  $Drugy1 = DB::table('druglists')->where('id','>=',$drt->company )->first();
                    $drugsumy=DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                    ->select('prescription_filled_status.price as dprice')
                    ->selectRaw('SUM(quantity) as quantity')
                    ->selectRaw('SUM(price*quantity) as qprice')
                    ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
                    ['prescription_filled_status.created_at','<=',$today],
                               ['prescription_details.drug_id','=',$drt->company], ])
                    ->whereNull('prescription_filled_status.substitute_presc_id')
                    ->first();

                    $subdrugsumy=DB::table('prescription_filled_status')
                    ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                    ->select('prescription_filled_status.price as dprice')
                    ->selectRaw('SUM(quantity) as quantity')
                    ->selectRaw('SUM(price*quantity) as qprice')
                    ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
                    ['prescription_filled_status.created_at','<=',$today],
                               ['substitute_presc_details.drug_id','=',$drt->company], ])
                    ->whereNotNull('prescription_filled_status.substitute_presc_id')
                    ->first();
                    ?>
                    <td>1</td>
                    <td>{{$Drugy1->drugname}}</td>
                    <td>{{$drugsumy->quantity}}</td>
                    <td>{{$drugsumy->qprice}}</td>
                    <td>{{$subdrugsumy->quantity}}</td>
                    <td>{{$subdrugsumy->qprice}}</td>
                    <td colspan="2">{{($drugsumy->qprice + $subdrugsumy->qprice)}}</td>

                 </tr>
                <tr>
                  <?php  $Drugy2 = DB::table('druglists')->where('id','>=',$drt->competition_1 )->first();
                  $drugsumy1=DB::table('prescription_filled_status')
                  ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                  ->select('prescription_filled_status.price as dprice')
                  ->selectRaw('SUM(quantity) as quantity')
                  ->selectRaw('SUM(price*quantity) as qprice')
                  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
                  ['prescription_filled_status.created_at','<=',$today],
                             ['prescription_details.drug_id','=',$drt->competition_1], ])
                  ->whereNull('prescription_filled_status.substitute_presc_id')
                  ->first();

                  $subdrugsumy1=DB::table('prescription_filled_status')
                  ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                  ->select('prescription_filled_status.price as dprice')
                  ->selectRaw('SUM(quantity) as quantity')
                  ->selectRaw('SUM(price*quantity) as qprice')
                  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
                            ['prescription_filled_status.created_at','<=',$today],
                             ['substitute_presc_details.drug_id','=',$drt->competition_1], ])
                  ->whereNotNull('prescription_filled_status.substitute_presc_id')
                  ->first();
                  ?>
                  <td>2</td>
                  <td>{{$Drugy2->drugname}}</td>
                  <td>{{$drugsumy1->quantity}}</td>
                  <td>{{$drugsumy1->qprice}}</td>
                  <td>{{$subdrugsumy1->quantity}}</td>
                  <td>{{$subdrugsumy1->qprice}}</td>
                  <td colspan="2">{{($drugsumy1->qprice + $subdrugsumy1->qprice)}}</td>
               </tr>
               <tr>
                 <?php  $Drugy3 = DB::table('druglists')->where('id','>=',$drt->competition_2 )->first();
                 $drugsumy2=DB::table('prescription_filled_status')
                 ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                 ->select('prescription_filled_status.price as dprice')
                 ->selectRaw('SUM(quantity) as quantity')
                 ->selectRaw('SUM(price*quantity) as qprice')
                 ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
                           ['prescription_filled_status.created_at','<=',$today],
                            ['prescription_details.drug_id','=',$drt->competition_2], ])
                 ->whereNull('prescription_filled_status.substitute_presc_id')
                 ->first();

                 $subdrugsumy2=DB::table('prescription_filled_status')
                 ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                 ->select('prescription_filled_status.price as dprice')
                 ->selectRaw('SUM(quantity) as quantity')
                 ->selectRaw('SUM(price*quantity) as qprice')
                 ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
                           ['prescription_filled_status.created_at','<=',$today],
                            ['substitute_presc_details.drug_id','=',$drt->competition_2], ])
                 ->whereNotNull('prescription_filled_status.substitute_presc_id')
                 ->first();
                 ?>
                 <td>3</td>
                 <td>{{$Drugy3->drugname}}</td>
                 <td>{{$drugsumy2->quantity}}</td>
                 <td>{{$drugsumy2->qprice}}</td>
                 <td>{{$subdrugsumy2->quantity}}</td>
                 <td>{{$subdrugsumy2->qprice}}</td>
                 <td colspan="2">{{($drugsumy2->qprice + $subdrugsumy2->qprice)}}</td>
              </tr>
              <tr>
                <?php  $Drugy4 = DB::table('druglists')->where('id','>=',$drt->competition_3 )->first();
                $drugsumy3=DB::table('prescription_filled_status')
                ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                ->select('prescription_filled_status.price as dprice')
                ->selectRaw('SUM(quantity) as quantity')
                ->selectRaw('SUM(price*quantity) as qprice')
                ->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
                           ['prescription_filled_status.created_at','<=',$today],
                           ['prescription_details.drug_id','=',$drt->competition_3], ])
                ->whereNull('prescription_filled_status.substitute_presc_id')
                ->first();

                $subdrugsumy3=DB::table('prescription_filled_status')
                ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                ->select('prescription_filled_status.price as dprice')
                ->selectRaw('SUM(quantity) as quantity')
                ->selectRaw('SUM(price*quantity) as qprice')
                ->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
                           ['prescription_filled_status.created_at','<=',$today],
                           ['substitute_presc_details.drug_id','=',$drt->competition_3], ])
                ->whereNotNull('prescription_filled_status.substitute_presc_id')
                ->first();
                 ?>
                <td>4</td>
                <td>{{$Drugy4->drugname}}</td>
                <td>{{$drugsumy3->quantity}}</td>
                <td>{{$drugsumy3->qprice}}</td>
                <td>{{$subdrugsumy3->quantity}}</td>
                <td>{{$subdrugsumy3->qprice}}</td>
                <td colspan="2">{{($drugsumy3->qprice + $subdrugsumy3->qprice)}}</td>
             </tr>
             <tr>
               <?php  $Drugy5 = DB::table('druglists')->where('id','>=',$drt->competition_4 )->first();
               $drugsumy4=DB::table('prescription_filled_status')
               ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
               ->select('prescription_filled_status.price as dprice')
               ->selectRaw('SUM(quantity) as quantity')
               ->selectRaw('SUM(price*quantity) as qprice')
               ->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
                           ['prescription_filled_status.created_at','<=',$today],
                          ['prescription_details.drug_id','=',$drt->competition_4], ])
               ->whereNull('prescription_filled_status.substitute_presc_id')
               ->first();

               $subdrugsumy4=DB::table('prescription_filled_status')
               ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
               ->select('prescription_filled_status.price as dprice')
               ->selectRaw('SUM(quantity) as quantity')
               ->selectRaw('SUM(price*quantity) as qprice')
               ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
                          ['prescription_filled_status.created_at','<=',$today],
                          ['substitute_presc_details.drug_id','=',$drt->competition_4], ])
               ->whereNotNull('prescription_filled_status.substitute_presc_id')
               ->first();
               ?>
               <td>5</td>
               <td>{{$Drugy5->drugname}}</td>
               <td>{{$drugsumy4->quantity}}</td>
               <td>{{$drugsumy4->qprice}}</td>
               <td>{{$subdrugsumy4->quantity}}</td>
               <td>{{$subdrugsumy4->qprice}}</td>
               <td colspan="2">{{($drugsumy4->qprice + $subdrugsumy4->qprice)}}</td>
            </tr>
            <tr>
              <?php  $Drugy6 = DB::table('druglists')->where('id','>=',$drt->competition_5 )->first();
              $drugsumy5=DB::table('prescription_filled_status')
              ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
              ->select('prescription_filled_status.price as dprice')
              ->selectRaw('SUM(quantity) as quantity')
              ->selectRaw('SUM(price*quantity) as qprice')
              ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
              ['prescription_filled_status.created_at','<=',$today],
                         ['prescription_details.drug_id','=',$drt->competition_5], ])
              ->whereNull('prescription_filled_status.substitute_presc_id')
              ->first();

              $subdrugsumy5=DB::table('prescription_filled_status')
              ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
              ->select('prescription_filled_status.price as dprice')
              ->selectRaw('SUM(quantity) as quantity')
              ->selectRaw('SUM(price*quantity) as qprice')
              ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
              ['prescription_filled_status.created_at','<=',$today],
                         ['substitute_presc_details.drug_id','=',$drt->competition_5], ])
              ->whereNotNull('prescription_filled_status.substitute_presc_id')
              ->first();
              ?>
              <td>6</td>
              <td>{{$Drugy6->drugname}}</td>
              <td>{{$drugsumy5->quantity}}</td>
              <td>{{$drugsumy5->qprice}}</td>
              <td>{{$subdrugsumy5->quantity}}</td>
              <td>{{$subdrugsumy5->qprice}}</td>
              <td colspan="2">{{($drugsumy5->qprice + $subdrugsumy5->qprice)}}</td>
           </tr>


                                 </tbody>
                              </table>
                          </div>
                          @endforeach
                        </div>
                     </div>
                 </div>
              </div>
          </div>

<!--................................. MAX ...........................-->
<div id="tab-45a" class="tab-pane">
    <div class="panel-body">
      <div class="ibox float-e-margins">
         <div class="col-md-12">
              <div class="ibox-content">
                <?php

              $Drugall = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();
         ?>
  @foreach($Drugall as $drt)
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
              <tr>
                <th>No</th>
                <th>Drug Name</th>
                <th colspan="2">DIRECT SALES</th>
                <th colspan="2">SUBSTITUTED SALES</th>
                <th colspan="2">TOTAL Sales</th>
              </tr>
              <tr>
                <th></th>
                <th></th>
                <th>Units</th>
                <th>Value</th>
                <th>Units</th>
                <th>Value</th>
                <th colspan="2">#</th>
              </tr>
            </thead>
            <tbody>


                <tr>
                 <?php  $Drug1all = DB::table('druglists')->where('id','>=',$drt->company )->first();
                  $drugsumall=DB::table('prescription_filled_status')
                  ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                  ->select('prescription_filled_status.price as dprice')
                  ->selectRaw('SUM(quantity) as quantity')
                  ->selectRaw('SUM(price*quantity) as qprice')
                  ->where([
                             ['prescription_details.drug_id','=',$drt->company], ])
                  ->whereNull('prescription_filled_status.substitute_presc_id')
                  ->first();

                  $subdrugsumall=DB::table('prescription_filled_status')
                  ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                  ->select('prescription_filled_status.price as dprice')
                  ->selectRaw('SUM(quantity) as quantity')
                  ->selectRaw('SUM(price*quantity) as qprice')
                  ->where([
                             ['substitute_presc_details.drug_id','=',$drt->company], ])
                  ->whereNotNull('prescription_filled_status.substitute_presc_id')
                  ->first();
                  ?>
                  <td>1</td>
                  <td>{{$Drug1all->drugname}}</td>
                  <td>{{$drugsumall->quantity}}</td>
                  <td>{{$drugsumall->qprice}}</td>
                  <td>{{$subdrugsumall->quantity}}</td>
                  <td>{{$subdrugsumall->qprice}}</td>
                  <td colspan="2">{{($drugsumall->qprice + $subdrugsumall->qprice)}}</td>

               </tr>
              <tr>
                <?php  $Drug2 = DB::table('druglists')->where('id','>=',$drt->competition_1 )->first();
                $drugsumall1=DB::table('prescription_filled_status')
                ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                ->select('prescription_filled_status.price as dprice')
                ->selectRaw('SUM(quantity) as quantity')
                ->selectRaw('SUM(price*quantity) as qprice')
                ->where([
                           ['prescription_details.drug_id','=',$drt->competition_1], ])
                ->whereNull('prescription_filled_status.substitute_presc_id')
                ->first();

                $subdrugsumall1=DB::table('prescription_filled_status')
                ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                ->select('prescription_filled_status.price as dprice')
                ->selectRaw('SUM(quantity) as quantity')
                ->selectRaw('SUM(price*quantity) as qprice')
                ->where([
                           ['substitute_presc_details.drug_id','=',$drt->competition_1], ])
                ->whereNotNull('prescription_filled_status.substitute_presc_id')
                ->first();
                ?>
                <td>2</td>
                <td>{{$Drug2->drugname}}</td>
                <td>{{$drugsumall1->quantity}}</td>
                <td>{{$drugsumall1->qprice}}</td>
                <td>{{$subdrugsumall1->quantity}}</td>
                <td>{{$subdrugsumall1->qprice}}</td>
                <td colspan="2">{{($drugsumall1->qprice + $subdrugsumall1->qprice)}}</td>
             </tr>
             <tr>
               <?php  $Drug3 = DB::table('druglists')->where('id','>=',$drt->competition_2 )->first();
               $drugsumall2=DB::table('prescription_filled_status')
               ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
               ->select('prescription_filled_status.price as dprice')
               ->selectRaw('SUM(quantity) as quantity')
               ->selectRaw('SUM(price*quantity) as qprice')
               ->where([
                          ['prescription_details.drug_id','=',$drt->competition_2], ])
               ->whereNull('prescription_filled_status.substitute_presc_id')
               ->first();

               $subdrugsumall2=DB::table('prescription_filled_status')
               ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
               ->select('prescription_filled_status.price as dprice')
               ->selectRaw('SUM(quantity) as quantity')
               ->selectRaw('SUM(price*quantity) as qprice')
               ->where([
                          ['substitute_presc_details.drug_id','=',$drt->competition_2], ])
               ->whereNotNull('prescription_filled_status.substitute_presc_id')
               ->first();
               ?>
               <td>3</td>
               <td>{{$Drug3->drugname}}</td>
               <td>{{$drugsumall2->quantity}}</td>
               <td>{{$drugsumall2->qprice}}</td>
               <td>{{$subdrugsumall2->quantity}}</td>
               <td>{{$subdrugsumall2->qprice}}</td>
               <td colspan="2">{{($drugsumall2->qprice + $subdrugsumall2->qprice)}}</td>
            </tr>
            <tr>
              <?php  $Drug4 = DB::table('druglists')->where('id','>=',$drt->competition_3 )->first();
              $drugsumall3=DB::table('prescription_filled_status')
              ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
              ->select('prescription_filled_status.price as dprice')
              ->selectRaw('SUM(quantity) as quantity')
              ->selectRaw('SUM(price*quantity) as qprice')
              ->where([
                         ['prescription_details.drug_id','=',$drt->competition_3], ])
              ->whereNull('prescription_filled_status.substitute_presc_id')
              ->first();

              $subdrugsumall3=DB::table('prescription_filled_status')
              ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
              ->select('prescription_filled_status.price as dprice')
              ->selectRaw('SUM(quantity) as quantity')
              ->selectRaw('SUM(price*quantity) as qprice')
              ->where([
                         ['substitute_presc_details.drug_id','=',$drt->competition_3], ])
              ->whereNotNull('prescription_filled_status.substitute_presc_id')
              ->first();
               ?>
              <td>4</td>
              <td>{{$Drug4->drugname}}</td>
              <td>{{$drugsumall3->quantity}}</td>
              <td>{{$drugsumall3->qprice}}</td>
              <td>{{$subdrugsumall3->quantity}}</td>
              <td>{{$subdrugsumall3->qprice}}</td>
              <td colspan="2">{{($drugsumall3->qprice + $subdrugsumall3->qprice)}}</td>
           </tr>
           <tr>
             <?php  $Drug5 = DB::table('druglists')->where('id','>=',$drt->competition_4 )->first();
             $drugsumall4=DB::table('prescription_filled_status')
             ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
             ->select('prescription_filled_status.price as dprice')
             ->selectRaw('SUM(quantity) as quantity')
             ->selectRaw('SUM(price*quantity) as qprice')
             ->where([
                        ['prescription_details.drug_id','=',$drt->competition_4], ])
             ->whereNull('prescription_filled_status.substitute_presc_id')
             ->first();

             $subdrugsumall4=DB::table('prescription_filled_status')
             ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
             ->select('prescription_filled_status.price as dprice')
             ->selectRaw('SUM(quantity) as quantity')
             ->selectRaw('SUM(price*quantity) as qprice')
             ->where([
                        ['substitute_presc_details.drug_id','=',$drt->competition_4], ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
             ->first();
             ?>
             <td>5</td>
             <td>{{$Drug5->drugname}}</td>
             <td>{{$drugsumall4->quantity}}</td>
             <td>{{$drugsumall4->qprice}}</td>
             <td>{{$subdrugsumall4->quantity}}</td>
             <td>{{$subdrugsumall4->qprice}}</td>
             <td colspan="2">{{($drugsumall4->qprice + $subdrugsumall4->qprice)}}</td>
          </tr>
          <tr>
            <?php  $Drug6 = DB::table('druglists')->where('id','>=',$drt->competition_5 )->first();
            $drugsumall5=DB::table('prescription_filled_status')
            ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
            ->select('prescription_filled_status.price as dprice')
            ->selectRaw('SUM(quantity) as quantity')
            ->selectRaw('SUM(price*quantity) as qprice')
            ->where([
                       ['prescription_details.drug_id','=',$drt->competition_5], ])
            ->whereNull('prescription_filled_status.substitute_presc_id')
            ->first();

            $subdrugsumall5=DB::table('prescription_filled_status')
            ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
            ->select('prescription_filled_status.price as dprice')
            ->selectRaw('SUM(quantity) as quantity')
            ->selectRaw('SUM(price*quantity) as qprice')
            ->where([
                       ['substitute_presc_details.drug_id','=',$drt->competition_5], ])
            ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->first();
            ?>
            <td>6</td>
            <td>{{$Drug6->drugname}}</td>
            <td>{{$drugsumall5->quantity}}</td>
            <td>{{$drugsumall5->qprice}}</td>
            <td>{{$subdrugsumall5->quantity}}</td>
            <td>{{$subdrugsumall5->qprice}}</td>
            <td colspan="2">{{($drugsumall5->qprice + $subdrugsumall5->qprice)}}</td>
         </tr>


                               </tbody>
                            </table>
                        </div>
                        @endforeach
                      </div>
                   </div>
               </div>
            </div>
        </div>


<!--................................. CUSTOM ...........................-->

<!--................................. CUSTOM ...........................-->


                              </div>
                            </div>
