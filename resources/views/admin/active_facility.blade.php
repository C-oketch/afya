@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')
<div class="content-page  equal-height">
  <div class="content">
    <div class="container">


      <div class="row">
        <div class="col-sm-11">

          <div class="panel-body">
            <div class="ibox float-e-margins">
              <div class="ibox-title">

              </div>

              <div class="ibox-content">
                <!-- sales All Custom-->
                <div class="table-responsive">
<a class="btn btn-primary"  href="{{route('addfacility')}}"> &nbsp;NEW </a>

  <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Facility Name</th>
                        <th>Patient</th>
                        <th>Visits</th>
                        <th>Appointments</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php  $i=1; ?>

                      @foreach ($facilities as $fact)
                      <?php
                      $visits=DB::table('appointments')->where('facility_id', $fact->FacilityCode)->count('id');
                      $appointments=DB::table('appointments')->where('facility_id', $fact->FacilityCode)
                      ->whereNotNull('appointment_date')
                      ->count('id');


                        // $allpatients=DB::table('patient_facility')->distinct('afya_user_id')
                        // ->where('facility_id', $fact->FacilityCode)->count('afya_user_id');
                       ?>
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{$fact->FacilityName}}</td>
                        <td>{{$fact->total}}</td>
                        <td>{{$visits}}</td>
                        <td>{{$appointments}}</td>
                          <td><a href="{{url('faci-single',$fact->FacilityCode)}}" class="btn btn-primary">View</a></td>
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
  </div>

  @endsection
  @section('script')

  <script>
  $(".select2_demo_1").select2();
  </script>
  @endsection
