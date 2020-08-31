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
                                                     <th>Registration Number</th>
                                                     <th>specialization</th>
                                                     <th>sub specialization</th>
                                                  </tr>

                                                  </thead>

                                                  <tbody>
                                                 
                                                @foreach ($doctors as $doctor)
                                                    <tr>
                                                    	
                                                    	<td>{{$doctor->name}}</td>
                                                    	<td>{{$doctor->regno}}</td>
                                                    	<td>{{$doctor->speciality}}</td>
                                                      <td>{{$doctor->subspeciality}}</td>                    	
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
