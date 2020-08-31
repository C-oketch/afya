@extends('layouts.nhif')
@section('title', 'Nhif Dashboard')
@section('content')

<?php use App\Http\Controllers\Controller; ?>

<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
              <div class="row">
              <div class="col-sm-12">
             
               <div class="panel-body">
                    <div class="ibox float-e-margins">
                               
                              <div class="ibox-title">
                                <h5>{{$dep}}</h5>
                                  <div class="ibox-tools">

                                      
                                  </div>
                              </div>

                              <div class="ibox-content">
                   <!-- sales All Custom-->
                                  <div class="table-responsive">
                                
                            
                 <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>

                                                  <tr>
                                                     <th>Facility Name</th>
                                                     <th>Number of patients</th>
                                                     <th>Number of activities</th>
                                                     <th>Total Cost</th>                                                     
                                                  </tr>

                                                  </thead>

                                                  <tbody>
                                              @foreach($facilities as $fac)
                                                    <tr>
                                                    	<td><a href="{{url('facility-patients?faci='.$fac->FacilityCode)}}">{{$fac->FacilityName}}</a></td>
                                                    	<td>{{Controller::number_of_patients($fac->FacilityCode)}}</td>
                                                    	<td>{{Controller::number_of_activities($fac->FacilityCode)}}</td> 
                                                    	<td></td> 
                                                    </tr>
                                              @endforeach 
                                                   </tbody>

                                                 </table>
                                                 </div>
                                                 </div>
                                                 </div>

                                </div>
                                </div>
 


 </div>



</div>
                   </div><!--container-->
                
@endsection
