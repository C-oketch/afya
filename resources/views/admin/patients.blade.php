@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
              <div class="row">
              <div class="col-sm-12">
             
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
                               
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                     <th>Name</th>
                                                     <th>Age</th>
                                                     <th>Gender</th>
                                                     <th>Constituency of Residence</th>
                                                     <th>County</th>
                                                     <th>Phone number</th>
                                                     
                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                 
                                                @foreach ($patients as $patient)
                                                    <tr>
                                                    	
                                                    	<td>{{$patient->firstname}} {{$patient->secondname}}</td>
                                                    	<td>{{$patient->age}}</td>
                                                    	<td>{{$patient->gender}}</td>
                                                      <td>{{$patient->constituency}}</td>
                                                      <td>{{$patient->constituency}}</td>
                                                      <td>{{$patient->msisdn}}</td>                      	
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
