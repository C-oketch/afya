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
                                   <a data-toggle="modal" class="btn btn-primary" href="#modal-formf">New</a>
                            
                            <div id="modal-formf" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-body">
          <form class="form-horizontal" role="form" method="POST" action="/addfacility" novalidate>
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
             <div class="form-group">
             <label for="exampleInputEmail1">Facility Code</label>
             <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="code">
             </div>
             <div class="form-group">
             <label for="exampleInputEmail1">Facility Name</label>
             <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name">
             </div>
              <div class="form-group">
             <label for="exampleInputPassword1">Type</label>
             <input type="text" class="form-control" id="exampleInputPassword1" name="type"/>
             </div>
             <div class="form-group">
             <label for="exampleInputPassword1">County</label>
             <input type="text" class="form-control" id="exampleInputPassword1" name="county"/>
             </div>
             <div class="form-group">
             <label for="exampleInputPassword1">Constituency</label>
             <input type="text" class="form-control" id="exampleInputPassword1" name="constituency"/>
             </div>
             <div class="form-group">
             <label for="exampleInputPassword1">Ward</label>
             <input type="text" class="form-control" id="exampleInputPassword1" name="ward"/>
             </div>

             <input type="submit" name="submit" value="Add" > 
    </form>
    </div>
    </div>
    </div>
    </div>
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                     <th>Facility Code</th>
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
                                                  
                                                 $facilities=DB::table('facilities')
                                                 ->get();?>
                                                  @foreach ($facilities as $fact)
                                                    <tr>
                                                    	<td>{{$i}}</td>
                                                    	<td>{{$fact->FacilityCode}}</td>
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
