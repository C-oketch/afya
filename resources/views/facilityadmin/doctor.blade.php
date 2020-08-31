@extends('layouts.facilityadmin')
@section('title', 'Dashboard')
@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
               <h1>Facility Doctors</h1>
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
                <a href="{{ URL::to('createdoc')}}" class="btn btn-primary">Add</a>

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
                                                $facilities=DB::table('facility_doctor')->join('users','users.id','=','facility_doctor.user_id')->join('facilities','facilities.FacilityCode','=','facility_doctor.facilitycode')
                                                 ->join('doctors','doctors.id','=','facility_doctor.doctor_id')
                                                 ->select('users.name as name','facility_doctor.*','facilities.*','doctors.*')->where('facility_doctor.facilitycode',$facilitycode->facilitycode)
                                                 ->get();?>
                                                  @foreach ($facilities as $fact)
                                                    <tr>
                                                      <td>{{$i}}</td>
                                                       <td>{{$fact->name}}</td>
                                                      <td>{{$fact->regno}}</td>
                                                      <td>{{$fact->regdate}}</td>
                                                      <td>{{$fact->address}}</td>
                                                      <td>{{$fact->qualifications}}</td>
                                                      <td>{{$fact->speciality}}</td>
                                                      <td>{{$fact->subspeciality}}</td>
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
