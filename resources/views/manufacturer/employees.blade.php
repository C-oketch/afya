@extends('layouts.manufacturer')
@section('title', 'Manufacturer')
@section('content')
  <div class="content-page  equal-height">
      
      <div class="content">
          <div class="container">



            <div class="wrapper wrapper-content animated fadeInRight">
                      <div class="row">
                          <div class="col-lg-11">
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
                              <a data-toggle="modal" class="btn btn-primary" href="#modal-form">Add Employee</a>
                                <div id="modal-form" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-body">
          
      <?php $id=Auth::user()->id;?>
       <form class="form-horizontal" role="form" method="POST" action="/addemployee" novalidate>
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="hidden" name="id" value="{{$id}}">
             <input type="hidden" name="role" value="Manufacturer"/>
             
          <div class="form-group">
            <label for="exampleInputPassword1">Name</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Name" name="name">
            </div>

            
          <div class="form-group">
            <label for="exampleInputPassword1">Email</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Email" name="email">
            </div>

            <div class="form-group">
            <label for="exampleInputPassword1">Employee Type</label>
            <select name="job" class="form-control">
             <option>Select</option>
              <option value="Manager">Manager</option>
              <option value="Sales Representatives">Sales Representatives</option>
            </select>
            </div>
          
            <div class="form-group">
            <label for="exampleInputPassword1">Default Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
            </div>
             <div class="form-group">
            <label for="exampleInputPassword1">Region</label>
            <select name="region" class="form-control">
            <?php $counties=DB::table('county')->get();?>
            @foreach($counties as $county)
           <option value="{{$county->county}}">{{$county->county}}</option>
            @endforeach              
            </select>
             </div>
            <input  type="submit" class="btn btn-primary btn btn-block " value="Add">
    </form>
     
      
      </div>
      </div>
      </div>
      </div>
<br><br>
                                  <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>
                                                                           
        
                                                      <tr>
                                                          <th>No</th>
                                                     <th>Name</th>
                                                     <th>Email</th>
                                                     <th>Group</th>
                                                     <th>Region</th>
                                                    <th>Joined Date</th>

                                                         </tr>
                                                    </tr>
                                                  </thead>

                                                  <tbody>
                                                    <?php 

                                                    $i=1;
                                                    $employees=DB::table('manufacturers_employees')->join('users','users.id','=','manufacturers_employees.users_id')->select('users.*','manufacturers_employees.job as job','manufacturers_employees.region')->where('manufacturers_employees.manu_id',$id)->get();

                                                    ?>

                                                    @foreach($employees as $employee)
                                                    <tr>
                                                      <td>{{$i}}</td>
                                                      <td>{{$employee->name}}</td>
                                                      <td>{{$employee->email}}</td>
                                                      <td>{{$employee->job}}</td>
                                                      <td>{{$employee->region}}</td>
                                                      <td>{{$employee->created_at}}</td>

                                                    </tr>


                                                    <?php $i++; ?>
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
@include('includes.default.footer')
          </div><!--content-->
      </div><!--content page-->

@endsection
