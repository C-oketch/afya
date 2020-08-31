@extends('layouts.nhif')
@section('title', 'Claims')
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
                                  <h5>Claims</h5>
                                  <div class="ibox-tools">
                                <a href="{{route('claims.create')}}" class="btn btn-primary">Enter Claim</a>
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
                               
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                     <th>Facility</th>
                                                     <th>Number of Patients</th>
                                                     <th>Claims Amount</th>
                                                    

                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                 
                                                @foreach ($claims as $claim)
                                                    <tr>
                                                                                                      
                            <td><a href="{{url('facility-claims?faci='.$claim->facility_id)}}">{{$claim->FacilityName}}</a></td> 
                                                    <td>{{Controller::patients_claiming_per_hospital($claim->facility_id)}}</td>
                                                      <td>Ksh {{number_format(Controller::cost_claimed_per_hospital($claim->facility_id),2)}}</td>                                                                      
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
