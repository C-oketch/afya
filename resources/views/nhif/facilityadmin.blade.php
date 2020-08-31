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
                   <a href="{{ URL::to('addAdmin')}}" class="btn btn-primary">Add</a>
                   <br>
                                  <div class="table-responsive">
                                  
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                      <th>No</th>
                                                     <th>Admin Name</th>
                                                     <th>Facility Name</th>
                                                     <th>Type</th>
                                                     <th>County</th>
                                                     <th>Constituency</th>
                                                     <th>Ward</th>

                                                  

                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                  <?php 
                                                  $i=1;
                                                  
                                                 $facilities=DB::table('facility_admin')->join('users','users.id','=','facility_admin.user_id')->join('facilities','facilities.FacilityCode','=','facility_admin.facilitycode')
                                                 ->select('users.name as name','facilities.*')
                                                 ->get();?>
                                                  @foreach ($facilities as $fact)
                                                    <tr>
                                                    	<td>{{$i}}</td>
                                                    	<td>{{$fact->name}}</td>
                                                    	<td>{{$fact->FacilityName}}</td>
                                                    	<td>{{$fact->Type}}</td>
                                                    	<td>{{$fact->County}}</td> 
                                                    	<td>{{$fact->Constituency}}</td> 
                                                    	
                                                    	<td>{{$fact->Ward}}</td> 
                                                    	                                        
      
                                                      

                                                    	
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



</div>
                   </div><!--container-->
                
@endsection
