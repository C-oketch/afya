@extends('layouts.facilityadmin')
@section('title', 'Dashboard')
@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
               <h1>Facility Clinical Officers</h1>
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
                    <?php $facilitycode=DB::table('facility_admin')->where('user_id', Auth::id())->first(); ?>

                              <div class="ibox-content">
                   <!-- sales All Custom-->
                 <a data-toggle="modal" class="btn btn-primary" href="#modal-formf">Add</a>
                            
                            <div id="modal-formf" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-body">
          <form class="form-horizontal" role="form" method="POST" action="/addfacilityofficer" novalidate>
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
              <div class="form-group">
             <label for="exampleInputEmail1">Name</label>
             <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  name="name"/>
             </div>
             <div class="form-group">
             <label for="exampleInputEmail1">RegNo</label>
             <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  name="regno"/>
             </div>
             <div class="form-group">
             <label for="exampleInputPassword1">Email</label>
             <input type="email" class="form-control" id="exampleInputPassword1"  name="email"  >
             </div>
             <div class="form-group">
             <label for="exampleInputPassword1">password</label>
             <input type="password" class="form-control" id="exampleInputPassword1"  name="password"  >
             </div>
             <div class="form-group">
             <label for="exampleInputEmail1">RegDate</label>
             <input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  name="regdate"/>
             </div>
             <div class="form-group">
             <label for="exampleInputEmail1">address</label>
             <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  name="address"/>
             </div>
              <div class="form-group">
             <label for="exampleInputEmail1">Qualification</label>
             <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  name="qualify"/>
             </div>
             <div class="form-group">
             <label for="exampleInputEmail1">Speciality</label>
             <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  name="speciality"/>
             </div>
             <div class="form-group">
             <label for="exampleInputEmail1">Sub Speciality</label>
             <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  name="sub_speciality"/>
             </div>
             <input type="hidden" name="role" value="Doctor">
             <input type="hidden" name="facility" value="{{$facilitycode->facilitycode}}">
             


             <input type="submit" name="submit" value="Add" > 
    </form>
         
                            </div>
                            </div>
                            </div>
                            </div>
                   <br>
                                  <div class="table-responsive">
                                  
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                      <th>No</th>
                                                      <th>Name</th>
                                                      <th>RegNo</th>
                                                      <th>RegDate</th>
                                                      <th>Address</th>
                                                      <th>Qualification</th>
                                                      <th>Speciality</th>
                                                      <th>Sub Speciality</th>
                                                   

                                                  

                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                  <?php 
                                                  $i=1;
                                                  
                                                 $facilities=DB::table('facility_officer')->join('users','users.id','=','facility_officer.user_id')->join('facilities','facilities.FacilityCode','=','facility_officer.facilitycode')
                                                 ->select('users.name as name','facility_officer.*','facilities.*')->where('facility_officer.facilitycode',$facilitycode->facilitycode)
                                                 ->get();?>
                                                  @foreach ($facilities as $fact)
                                                    <tr>
                                                      <td>{{$i}}</td>
                                                       <td>{{$fact->name}}</td>
                                                      <td>{{$fact->regno}}</td>
                                                      <td>{{$fact->regdate}}</td>
                                                      <td>{{$fact->address}}</td>
                                                      <td>{{$fact->qualification}}</td> 
                                                      <td>{{$fact->speciality}}</td> 
                                                      <td>{{$fact->sub_speciality}}</td> 
                                                                                              
      
                                                      

                                                      
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
