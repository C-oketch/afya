 <div id="tab-3" class="tab-pane">
                             <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-31a">Today</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-32a">This Week</a></li>
                             <li class=""><a data-toggle="tab" href="#tab-33a">This Month</a></li>
                          <li class=""><a data-toggle="tab" href="#tab-34a">This Year</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-35a">Max</a></li>
                             <li class=""><a data-toggle="tab" href="#tab-36a">Custom</a></li>
                        </ul>
                        <br>
                        <div class="tab-content">
                          <div id="tab-31a" class="tab-pane active">
                              <div class="panel-body">
                                <div class="ibox float-e-margins">
         <div class="col-md-12">
              <div class="ibox-content">
                      <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >

                              <thead>
                            <tr>
                             <th>No</th>
                            <th>Doctor</th>

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
                       $Dt = DB::table('prescription_filled_status')
                          ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                          ->join('druglists','druglists.id','=','prescription_details.drug_id')
                          ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
                          ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
                          ->join('doctors','appointments.doc_id','=','doctors.id')

                          ->select('doctors.name as name', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
                            ->groupBy('name')
                            ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                                     ])

                             ->orderBy('totalq', 'desc')
                              ->get();
                             ?>
                  @foreach($Dt as $doctor)
                      <tr>
                  <td>{{$i}}</td>
                  <td>{{$doctor->name}}</td>
                      @if($Companiez11)
                <?php  $Dco1t = DB::table('prescription_filled_status')
                ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                ->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
                ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
                ->join('doctors','appointments.doc_id','=','doctors.id')
                     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                     ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                               ['doctors.name','=', $doctor->name],
                               ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
                      ->first(); ?>
                   <td>{{$Dco1t->totalq1 }}</td>
                   <td>{{$Dco1t->total1 }}</td>
                   @endif
                   @if($Companiez1)
                   <?php  $Dco2t = DB::table('prescription_filled_status')
                   ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                   ->join('druglists','druglists.id','=','prescription_details.drug_id')
                   ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
                   ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
                   ->join('doctors','appointments.doc_id','=','doctors.id')
                        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                        ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                                  ['doctors.name','=', $doctor->name],
                                  ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
                          ->first();  ?>

                             <td>{{$Dco2t ->totalq1 }}</td>
                             <td>{{$Dco2t ->total1 }}</td>
                             @endif
                             @if($Companiez2)

       <?php  $Dco3t = DB::table('prescription_filled_status')
       ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
       ->join('druglists','druglists.id','=','prescription_details.drug_id')
       ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
       ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
       ->join('doctors','appointments.doc_id','=','doctors.id')
            ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
            ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                      ['doctors.name','=', $doctor->name],
                      ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
             ->first();  ?>
                       <td>{{$Dco3t->totalq1}}</td>
                       <td>{{$Dco3t->total1}}</td>

                       @endif
                       @if($Companiez3)
     <?php  $Dco4t = DB::table('prescription_filled_status')
     ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
     ->join('druglists','druglists.id','=','prescription_details.drug_id')
     ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
     ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
     ->join('doctors','appointments.doc_id','=','doctors.id')
          ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
          ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                    ['doctors.name','=', $doctor->name],
                    ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
           ->first(); ?>
                     <td>{{$Dco4t->totalq1}}</td>
                     <td>{{$Dco4t->total1}}</td>
                     @endif
                     @if($Companiez4)
               <?php  $Dco5t = DB::table('prescription_filled_status')
               ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
               ->join('druglists','druglists.id','=','prescription_details.drug_id')
               ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
               ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
               ->join('doctors','appointments.doc_id','=','doctors.id')
                    ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                    ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                              ['doctors.name','=', $doctor->name],
                              ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
                     ->first(); ?>

                               <td>{{$Dco5t->totalq1}}</td>
                               <td>{{$Dco5t->total1}}</td>
                               @endif
                               @if($Companiez5)
       <?php  $Dco6t = DB::table('prescription_filled_status')
       ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
       ->join('druglists','druglists.id','=','prescription_details.drug_id')
       ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
       ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
       ->join('doctors','appointments.doc_id','=','doctors.id')
            ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
            ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                      ['doctors.name','=', $doctor->name],
                      ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
             ->first(); ?>
                       <td>{{$Dco6t->totalq1}}</td>
                       <td>{{$Dco6t->total1}}</td>
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
  <div id="tab-32a" class="tab-pane">
      <div class="panel-body">
        <div class="ibox float-e-margins">
  <div class="col-md-12">
  <div class="ibox-content">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-example" >

      <thead>
    <tr>
     <th>No</th>
    <th>Doctor</th>

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
  $Dw = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')

  ->select('doctors.name as name', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
    ->groupBy('name')
    ->where([
             ['prescription_filled_status.created_at','>=',$one_week_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
                      ])

     ->orderBy('totalq', 'desc')
      ->get();
     ?>
  @foreach($Dw as $doctor)
  <tr>
  <td>{{$i}}</td>
  <td>{{$doctor->name}}</td>
      @if($Companiez11)
  <?php  $Dco1w = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
          ['prescription_filled_status.created_at','<=',$todaysales],
       ['doctors.name','=', $doctor->name],
       ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
  ->first(); ?>
  <td>{{$Dco1w->totalq1 }}</td>
  <td>{{$Dco1w->total1 }}</td>
  @endif
  @if($Companiez1)
  <?php  $Dco2w = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
          ['doctors.name','=', $doctor->name],
          ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
  ->first();  ?>

     <td>{{$Dco2w ->totalq1 }}</td>
     <td>{{$Dco2w ->total1 }}</td>
     @endif
     @if($Companiez2)
  <?php  $Dco3w = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['doctors.name','=', $doctor->name],
  ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
  ->first();  ?>
  <td>{{$Dco3w->totalq1}}</td>
  <td>{{$Dco3w->total1}}</td>

  @endif
  @if($Companiez3)
  <?php  $Dco4w = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['doctors.name','=', $doctor->name],
  ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
  ->first(); ?>
  <td>{{$Dco4w->totalq1}}</td>
  <td>{{$Dco4w->total1}}</td>
  @endif
  @if($Companiez4)
  <?php  $Dco5w = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
      ['doctors.name','=', $doctor->name],
      ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
  ->first(); ?>
       <td>{{$Dco5w->totalq1}}</td>
       <td>{{$Dco5w->total1}}</td>
       @endif
       @if($Companiez5)
  <?php  $Dco6w = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['doctors.name','=', $doctor->name],
  ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
  ->first(); ?>
  <td>{{$Dco6w->totalq1}}</td>
  <td>{{$Dco6w->total1}}</td>
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
  <!--................................. THIS MONTH...........................-->
  <div id="tab-33a" class="tab-pane">
      <div class="panel-body">
        <div class="ibox float-e-margins">
  <div class="col-md-12">
  <div class="ibox-content">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-example" >

      <thead>
    <tr>
     <th>No</th>
    <th>Doctor</th>

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
  $one_month_ago = Carbon::now()->subMonths(1);
  $i =1;
  $Dm = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')

  ->select('doctors.name as name', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
    ->groupBy('name')
    ->where([
             ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
                      ])

     ->orderBy('totalq', 'desc')
      ->get();
     ?>
  @foreach($Dm as $doctor)
  <tr>
  <td>{{$i}}</td>
  <td>{{$doctor->name}}</td>
      @if($Companiez11)
  <?php  $Dco1m = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
          ['prescription_filled_status.created_at','<=',$todaysales],
       ['doctors.name','=', $doctor->name],
       ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
  ->first(); ?>
  <td>{{$Dco1m->totalq1 }}</td>
  <td>{{$Dco1m->total1 }}</td>
  @endif
  @if($Companiez1)
  <?php  $Dco2m = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
          ['doctors.name','=', $doctor->name],
          ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
  ->first();  ?>

     <td>{{$Dco2m ->totalq1 }}</td>
     <td>{{$Dco2m ->total1 }}</td>
     @endif
     @if($Companiez2)
  <?php  $Dco3m = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['doctors.name','=', $doctor->name],
  ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
  ->first();  ?>
  <td>{{$Dco3m->totalq1}}</td>
  <td>{{$Dco3m->total1}}</td>
  @endif
  @if($Companiez3)

  <?php  $Dco4m = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['doctors.name','=', $doctor->name],
  ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
  ->first(); ?>
  <td>{{$Dco4m->totalq1}}</td>
  <td>{{$Dco4m->total1}}</td>
  @endif
  @if($Companiez4)
  <?php  $Dco5m = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
      ['doctors.name','=', $doctor->name],
      ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
  ->first(); ?>
       <td>{{$Dco5m->totalq1}}</td>
       <td>{{$Dco5m->total1}}</td>
       @endif
       @if($Companiez5)
  <?php  $Dco6m = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['doctors.name','=', $doctor->name],
  ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
  ->first(); ?>
  <td>{{$Dco6m->totalq1}}</td>
  <td>{{$Dco6m->total1}}</td>
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
  <!--................................. THIS YEAR...........................-->
  <div id="tab-34a" class="tab-pane">
      <div class="panel-body">
        <div class="ibox float-e-margins">
  <div class="col-md-12">
  <div class="ibox-content">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-example" >

      <thead>
    <tr>
     <th>No</th>
    <th>Doctor</th>

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
  $one_year_ago = Carbon::now()->subYears(1);
  $i =1;
  $Dy = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')

  ->select('doctors.name as name', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
    ->groupBy('name')
    ->where([
             ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
                      ])

     ->orderBy('totalq', 'desc')
      ->get();
     ?>
  @foreach($Dy as $doctor)
  <tr>
  <td>{{$i}}</td>
  <td>{{$doctor->name}}</td>
      @if($Companiez11)
  <?php  $Dco1y = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
          ['prescription_filled_status.created_at','<=',$todaysales],
       ['doctors.name','=', $doctor->name],
       ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
  ->first(); ?>
  <td>{{$Dco1y->totalq1 }}</td>
  <td>{{$Dco1y->total1 }}</td>
  @endif
  @if($Companiez1)
  <?php  $Dco2y = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
          ['doctors.name','=', $doctor->name],
          ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
  ->first();  ?>

     <td>{{$Dco2y ->totalq1 }}</td>
     <td>{{$Dco2y ->total1 }}</td>
     @endif
     @if($Companiez2)
  <?php  $Dco3y = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['doctors.name','=', $doctor->name],
  ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
  ->first();  ?>
  <td>{{$Dco3y->totalq1}}</td>
  <td>{{$Dco3y->total1}}</td>
  @endif
  @if($Companiez3)

  <?php  $Dco4y = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['doctors.name','=', $doctor->name],
  ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
  ->first(); ?>
  <td>{{$Dco4y->totalq1}}</td>
  <td>{{$Dco4y->total1}}</td>
  @endif
  @if($Companiez4)
  <?php  $Dco5y = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
      ['doctors.name','=', $doctor->name],
      ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
  ->first(); ?>
       <td>{{$Dco5y->totalq1}}</td>
       <td>{{$Dco5y->total1}}</td>
       @endif
       @if($Companiez5)
  <?php  $Dco6y = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['doctors.name','=', $doctor->name],
  ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
  ->first(); ?>
  <td>{{$Dco6y->totalq1}}</td>
  <td>{{$Dco6y->total1}}</td>
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

<!--................................. MAX ...........................-->
<div id="tab-35a" class="tab-pane">
    <div class="panel-body">
      <div class="ibox float-e-margins">
<div class="col-md-12">
<div class="ibox-content">
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover dataTables-example" >

    <thead>
  <tr>
   <th>No</th>
  <th>Doctor</th>

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
$Dall = DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->join('doctors','appointments.doc_id','=','doctors.id')

->select('doctors.name as name', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
  ->groupBy('name')
  ->where([
           ['prescription_filled_status.created_at','>=',$one_year_ago],
           ['prescription_filled_status.created_at','<=',$todaysales],
                    ])

   ->orderBy('totalq', 'desc')
    ->get();
   ?>
@foreach($Dall as $doctor)
<tr>
<td>{{$i}}</td>
<td>{{$doctor->name}}</td>
    @if($Companiez11)
<?php  $Dco1all = DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->join('doctors','appointments.doc_id','=','doctors.id')
->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
->where([
     ['doctors.name','=', $doctor->name],
     ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
->first(); ?>
<td>{{$Dco1all->totalq1 }}</td>
<td>{{$Dco1all->total1 }}</td>
@endif
@if($Companiez1)
<?php  $Dco2all = DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->join('doctors','appointments.doc_id','=','doctors.id')
->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
->where([
        ['doctors.name','=', $doctor->name],
        ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
->first();  ?>

   <td>{{$Dco2all ->totalq1 }}</td>
   <td>{{$Dco2all ->total1 }}</td>
   @endif
   @if($Companiez2)

<?php  $Dco3all = DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->join('doctors','appointments.doc_id','=','doctors.id')
->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
->where([
['doctors.name','=', $doctor->name],
['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
->first();  ?>
<td>{{$Dco3all->totalq1}}</td>
<td>{{$Dco3all->total1}}</td>

@endif
@if($Companiez3)
<?php  $Dco4all = DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->join('doctors','appointments.doc_id','=','doctors.id')
->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
->where([
['doctors.name','=', $doctor->name],
['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
->first(); ?>
<td>{{$Dco4all->totalq1}}</td>
<td>{{$Dco4all->total1}}</td>
@endif
@if($Companiez4)
<?php  $Dco5all = DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->join('doctors','appointments.doc_id','=','doctors.id')
->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
->where([
    ['doctors.name','=', $doctor->name],
    ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
->first(); ?>
     <td>{{$Dco5all->totalq1}}</td>
     <td>{{$Dco5all->total1}}</td>
     @endif
     @if($Companiez5)
<?php  $Dco6all = DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->join('doctors','appointments.doc_id','=','doctors.id')
->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
->where([
['doctors.name','=', $doctor->name],
['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
->first(); ?>
<td>{{$Dco6all->totalq1}}</td>
<td>{{$Dco6all->total1}}</td>
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
