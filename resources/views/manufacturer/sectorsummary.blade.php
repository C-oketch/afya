@extends('layouts.manufacturer')
@section('title', 'Manufacturer')
@section('content')

<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
<?php
  $id=Auth::id();
 $emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', Auth::id())->first();

}
  $Mname = $manufacturer->name;
  $Mid = $manufacturer->id;
  ?>

<div class="row">
<h1> Sector Summary</h1>

<div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">By Companies</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2">By Drugs</a></li>
                             <li class=""><a data-toggle="tab" href="#tab-3">By Dosage Form</a></li>
                        </ul>
                        <br>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">

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
                   <!-- sales All Custom-->
                                  <div class="table-responsive">
                               @if(!empty($rep))
                                 <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                     <th>Company</th>

                                                          <th>Total Sales</th>
                                                           <th>Market Share(%)</th>

                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                  <?php
                                                  $i=1;

                                                 $companies=DB::table('prescription_filled_status')
                                                  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                                                  ->join('druglists','druglists.id','=','prescription_details.drug_id')
                                                  ->where('druglists.id',$rep->drug_id)
                                                 ->select('druglists.manufacturer as name')
                                                 ->selectRaw('SUM(price * quantity) as total')->orderby('total','DESC')->limit(10)->get();?>
                                                  @foreach ($companies as $company)
                                                    <tr>
                                                      <td>{{$i}}</td>
                                                      <td>{{$company->name}}</td>
                                                      <td>{{$company->total}}</td>
                                                      <td>
                                                   <?php $sales=DB::table('prescription_filled_status')->selectRaw('SUM(price * quantity) as totals')->first();

                                                       echo $company->total/$sales->totals * 100;
                                                   ?>



                                                      </td>
                                                    </tr>

                                                     <?php $i++;  ?>
                                                        @endforeach
                                                   </tbody>

                                                 </table>

                                @else
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                     <th>Company</th>

                                                          <th>Total Sales</th>
                                                           <th>Market Share(%)</th>

                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                  <?php
                                                  $i=1;

                                                 $companies=DB::table('prescription_filled_status')
                                                  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                                                  ->join('druglists','druglists.id','=','prescription_details.drug_id')
                                                 ->select('druglists.manufacturer as name')
                                                 ->selectRaw('SUM(price * quantity) as total')->orderby('total','DESC')->limit(10)->get();?>
                                                  @foreach ($companies as $company)
                                                    <tr>
                                                    	<td>{{$i}}</td>
                                                    	<td>{{$company->name}}</td>
                                                    	<td>{{$company->total}}</td>
                                                    	<td>
                                                   <?php $sales=DB::table('prescription_filled_status')->selectRaw('SUM(price * quantity) as totals')->first();

                                                       echo $company->total/$sales->totals * 100;
                                                   ?>



                                                    	</td>
                                                    </tr>

                                                     <?php $i++;  ?>
                                                        @endforeach
                                                   </tbody>

                                                 </table>
                                        @endif
                                                 </div>
                                                 </div>
                                                 </div>

                                </div>

                            </div>
                            <div id="tab-2" class="tab-pane ">
                            <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">

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
                   <!-- sales All Custom-->

                                  <div class="table-responsive">

                             @if(!empty($rep))
                             <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                     <th>Drug Name</th>
                                                           <th>Total Sales (Kes millions)</th>
                                                           <th>Growth (%)</th>
                                                           <th> Company Name</th>
                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                  <?php
                                                  $i=1;

                                                 $companies=DB::table('prescription_filled_status')
                                                  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                                                  ->join('druglists','druglists.id','=','prescription_details.drug_id')
                                                  ->where('druglists.id',$rep->drug_id)
                                                 ->select('druglists.manufacturer as name','druglists.drugname as drugname')
                                                 ->selectRaw('SUM(price * quantity) as total')->orderby('total','DESC')->limit(10)->get();?>
                                                  @foreach ($companies as $company)
                                                    <tr>
                                                      <td>{{$i}}</td>
                                                      <td>{{$company->drugname}}</td>
                                                      <td>{{$company->total}}</td>
                                                      <td>
                                                   <?php $sales=DB::table('prescription_filled_status')->selectRaw('SUM(price * quantity) as totals')->first();

                                                       echo $company->total/$sales->totals * 100;
                                                   ?>

                                                      </td>
                                                      <td>{{$company->name}}</td>

                                                    </tr>

                                                     <?php $i++;  ?>
                                                        @endforeach


                                                   </tbody>

                                                 </table>

                             @else
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                     <th>Drug Name</th>
                                                           <th>Total Sales (Kes millions)</th>
                                                           <th>Growth (%)</th>
                                                           <th> Company Name</th>
                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                  <?php
                                                  $i=1;

                                                 $companies=DB::table('prescription_filled_status')
                                                  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                                                  ->join('druglists','druglists.id','=','prescription_details.drug_id')
                                                 ->select('druglists.manufacturer as name','druglists.drugname as drugname')
                                                 ->selectRaw('SUM(price * quantity) as total')->orderby('total','DESC')->limit(10)->get();?>
                                                  @foreach ($companies as $company)
                                                    <tr>
                                                    	<td>{{$i}}</td>
                                                    	<td>{{$company->drugname}}</td>
                                                    	<td>{{$company->total}}</td>
                                                    	<td>
                                                   <?php $sales=DB::table('prescription_filled_status')->selectRaw('SUM(price * quantity) as totals')->first();

                                                       echo $company->total/$sales->totals * 100;
                                                   ?>



                                                    	</td>
                                                    	<td>{{$company->name}}</td>

                                                    </tr>

                                                     <?php $i++;  ?>
                                                        @endforeach


                                                   </tbody>

                                                 </table>
                                          @endif
                                                 </div>
                                                 </div>
                                                 </div>

                                </div>

                            </div>
                             <div id="tab-3" class="tab-pane ">
                             <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">

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
                   <!-- sales All Custom-->
                                  <div class="table-responsive">
                            @if(!empty($rep))
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                     <th>Drug Name</th>

                                                          <th>Prescribing Doctor</th>
                                                           <th>Facility</th>
                                                          <th>Pharmacy  name</th>
                                                         <th> Quantity</th>
                                                         <th>Dosage</th>
                                                         <th>Unit Cost</th>
                                                         <th>Total </th>
                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                   <?php  $i=1;
                                                    $companies=DB::table('prescription_filled_status')
                                                  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                                                  ->join('druglists','druglists.id','=','prescription_details.drug_id')
                                                  ->join('pharmacy','pharmacy.id','=','prescription_filled_status.outlet_id')
                                                  ->join('prescriptions','prescriptions.id','=','prescription_details.presc_id')
                                                       ->join('appointments','appointments.id','=','prescriptions.appointment_id')
                                                        ->join('doctors','doctors.id','=','appointments.doc_id')->select('druglists.manufacturer as name','druglists.drugname as drugname','druglists.id as id','prescription_filled_status.price as price','prescription_filled_status.quantity as quantity','prescription_filled_status.dose_given as dosage','pharmacy.name as pharmacy','appointments.facility_id as Facility','doctors.name as docname')
                                                   ->where('druglists.id',$rep->drug_id)
                                                 ->selectRaw('SUM(price * quantity) as total')->orderby('total','DESC')->limit(10)->get();?>
                                                   @foreach($companies as $company)
                                                   <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$company->drugname}}</td>
                                                    <td>{{$company->docname}}</td>
             <td><?php   $fac=DB::table('facilities')->where('FacilityCode',$company->Facility)->first();?>{{$fac->FacilityName or ''}}</td>
                                                     <td>{{$company->pharmacy}}</td>
                                                     <td>{{$company->quantity}}</td>
                                                     <td>{{$company->dosage}}</td>
                                                     <td>{{$company->price}}</td>
                                                     <td>{{$company->total}}</td>
                                                   </tr>


                                                   <?php $i++;  ?>
                                                   @endforeach

                                                   </tbody>

                                                 </table>
                            @else
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                     <th>Drug Name</th>

                                                          <th>Prescribing Doctor</th>
                                                           <th>Facility</th>
                                                          <th>Pharmacy  name</th>
                                                         <th> Quantity</th>
                                                         <th>Dosage</th>
                                                         <th>Unit Cost</th>
                                                         <th>Total </th>
                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                   <?php  $i=1;
                                                    $companies=DB::table('prescription_filled_status')
                                                  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                                                  ->join('druglists','druglists.id','=','prescription_details.drug_id')
                                                  ->join('pharmacy','pharmacy.id','=','prescription_filled_status.outlet_id')
                                         ->join('prescriptions','prescriptions.id','=','prescription_details.presc_id')

                                                  ->join('appointments','appointments.id','=','prescriptions.appointment_id')
                                                  ->join('doctors','doctors.id','=','appointments.doc_id')->select('druglists.manufacturer as name','druglists.drugname as drugname','druglists.id as id','prescription_filled_status.price as price','prescription_filled_status.quantity as quantity','prescription_filled_status.dose_given as dosage','pharmacy.name as pharmacy','appointments.facility_id as Facility','doctors.name as docname')
                                                 ->selectRaw('SUM(price * quantity) as total')->orderby('total','DESC')->limit(10)->get();?>
                                                   @foreach($companies as $company)
                                                   <tr>
                                                   	<td>{{$i}}</td>
                                                   	<td>{{$company->drugname}}</td>
                                                   	<td>{{$company->docname}}</td>
             <td><?php   $fac=DB::table('facilities')->where('FacilityCode',$company->Facility)->first(); echo $fac->FacilityName;  ?></td>
                                                   	 <td>{{$company->pharmacy}}</td>
                                                   	 <td>{{$company->quantity}}</td>
                                                   	 <td>{{$company->dosage}}</td>
                                                   	 <td>{{$company->price}}</td>
                                                   	 <td>{{$company->total}}</td>
                                                   </tr>


                                                   <?php $i++;  ?>
                                                   @endforeach

                                                   </tbody>

                                                 </table>
                                                 @endif
                                                 </div>
                                                 </div>
                                                 </div>

                                </div>

                            </div>
                         </div>
                         </div>
                         </div>
                         </div>

 @include('includes.default.footer')
                   </div><!--container-->
                </div><!--content -->
            </div><!--content page-->
@endsection
