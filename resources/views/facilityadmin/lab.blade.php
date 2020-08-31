@extends('layouts.facilityadmin')
@section('title', 'Dashboard')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
          <div class="content">
              <div class="container">
                <div class="row" id="labpersonnel">
                        <div class="col-lg-11">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Facility Lab Personnel</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                      <button type="button"  class="btn btn-primary" onclick="myFunction()">Click to Add Lab Personnel</button>

                                    </a>
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                        <i class="fa fa-wrench"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user">
                                    </ul>
                                    <a class="close-link">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-12">
                            <div  id="labp" class="ficha">

                              <div class="row wrapper border-bottom white-bg page-heading col-lg-11">
                               <?php $facilitycode=DB::table('facility_admin')->where('user_id', Auth::id())->first(); ?>

                                           <div class="ibox-title">
                                             <h5>Add Laboratory Personnel</h5>
                                           </div>

                                           <form class="form-horizontal" role="form" method="POST" action="/facilitytest" novalidate>
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                  <div class="col-lg-3">

                                           <div class="form-group">
                                          <label for="exampleInputPassword1">Username</label>
                                          <input type="name" class="form-control"  name="name" required="">
                                          </div>

                                          <div class="form-group">
                                         <label for="exampleInputPassword1">Email</label>
                                         <input type="email" class="form-control"  name="email" required="">
                                         </div>

                                         <div class="form-group">
                                         <label for="exampleInputPassword1">Password</label>
                                         <input type="text" class="form-control"  name="password" required="">
                                         </div>

                                        <div class="form-group">
                                          <input type="hidden" name="facility" value="{{$facilitycode->facilitycode}}">
                                          <input type="hidden" name="role" value="Test"> </div>
                            </div>
                             <div class="col-lg-3 col-md-offset-1">
                                          <div class="form-group">
                                         <label>First Name:</label>
                                         <input type="text" name="firstname" class="form-control" required="" >
                                         </div>
                                         <div class="form-group">
                                        <label>Last Name:</label>
                                        <input type="text" name="lastname" class="form-control" required="" >
                                        </div>
                                        <div class="form-group">
                                       <label>Address</label>
                                       <input type="text" name="address" class="form-control" required="" >
                                       </div>
                                       <div class="form-group">
                                      <label>Phone</label>
                                      <input type="text" name="phone" class="form-control" required="" >
                                      </div>

                            </div>
                            <div class="col-lg-3 col-md-offset-1">

                             <div class="form-group">
                             <label for="tag_list" class="">Department:</label>
                             <select class="test-multiple" name="department"  style="width: 100%" required="">
                             <option value=''>Choose one</option>
                             <option value='Radiology'>Radiology</option>
                             <option value='Laboratory'>Laboratory</option>
                             <option value='Neurology'>Neurology</option>
                             <option value='Gastrointestinal'>Gastrointestinal</option>
                             </select>
                             </div>

                             <div class="form-group">
                             <label for="tag_list" class="">Speciality:</label>
                             <select class="test-multiple" name="speciality"  style="width: 100%" required="">
                             <option value=''>Choose one</option>
                             <option value='Technologist'>Technologist</option>
                             <option value='Registrar'>Registrar</option>
                             </select>
                             </div>

                                     <div class="form-group">
                                    <label>Qualification</label>
                                    <input type="text" name="qualification" class="form-control" required="">
                                    </div>
                                  </div>
                            <div class="col-md-12 col-md-offset-10">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                                 {!! Form::close() !!}

                                </div>
                              </div>
                            </div>
                            <div class="ibox-content">

                                <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                              <tr>
                              <th>No</th>
                              <th>First Name</th>
                              <th>Last Name</th>
                              <th>Department</th>
                              <th>Address</th>
                              <th>Phone</th>
                              <th>Qualification</th>
                              <th>Speciality</th>
                              <th>Action</th>

                           </tr>
                            </thead>
                            <tbody>
                        <?php $facilitycode=DB::table('facility_admin')->where('user_id', Auth::id())->first(); ?>
                        <?php
                        $i=1;
                      $facilities=DB::table('facility_test')
                       ->join('users','facility_test.user_id','=','users.id')
                       ->join('facilities','facility_test.facilitycode','=','facilities.FacilityCode')
                       ->select('facility_test.*','facilities.*','users.id as uid',
                       'facility_test.firstname as Fname','facility_test.secondname as sname')
                       ->where('facility_test.facilitycode',$facilitycode->facilitycode)
                       ->get();?>
                        @foreach ($facilities as $fact)
                          <tr>
                            <td>{{$i}}</td>
                            <td>{{$fact->Fname}}</td>
                            <td>{{$fact->sname}}</td>
                            <td>{{$fact->department}}</td>
                            <td>{{$fact->address}}</td>
                            <td>{{$fact->phone}}</td>
                            <td>{{$fact->qualification}}</td>
                            <td>{{$fact->speciality}}</td>
                            <td><a  href="{{route('labtechperson',$fact->uid)}}">update</a>

                          {!! Form::open(['method' => 'DELETE','route' => ['labtech.destroy', $fact->uid],'style'=>'display:inline']) !!}
                           {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                           {!! Form::close() !!}
                            </td>
                            </tr>
                              <?php $i++;  ?>
                              @endforeach
                         </tbody>

                            </tbody>
                            <tfoot>
                            <tr>

                            </tr>
                            </tfoot>
                            </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    </div>


</div>

</div>
</div><!--container-->

@include('includes.default.footer')

@endsection
