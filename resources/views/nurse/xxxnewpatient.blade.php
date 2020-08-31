
@extends('layouts.nurse')
@section('title', 'New patients')
@section('content')
  <div class="content-page  equal-height">
      <span class="label label-info"></span>
      <div class="content">
          <div class="container">


            <div class="wrapper wrapper-content animated fadeInRight">
              <div class="row">
              <div class="col-lg-10 col-lg-offset-1">
              <div class="ibox float-e-margins">
              <div class="ibox-title">
               <h5>Today Patient Details</h5>


            </div>
            <div class="ibox-content">

                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
              <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Gender</th>
                  <th>Age</th>
                  <th>Date</th>
            </tr>
          </thead>


          <tbody>
            <?php
            $i =1;
            ?>
         @foreach($patients as $patient)
              <tr>
@if($patient->persontreated == "Self")
        <?php
        $parent=DB::table('afya_users')->where('id',$patient->afya_user_id)->first();
        $gender=$parent->gender;
        $dob=$parent->dob;
        $interval = date_diff(date_create(), date_create($dob));
        $age= $interval->format(" %Y Year, %M Months, %d Days Old");

        ?>
         <td><a href="{{route('nurse.show',$parent->id)}}">{{$i}}</a></td>
        <td><a href="{{route('nurse.show',$parent->id)}}">{{$parent->firstname}} {{$parent->secondName}}</a></td>
        <td><a href="{{route('nurse.show',$parent->id)}}">{{$gender}}</a></td>
        <td><a href="{{route('nurse.show',$parent->id)}}">{{$age}}</a></td>
        <td><a href="{{route('nurse.show',$parent->id)}}">{{$patient->created_at}}</a></td>
  @else
      <?php
      $depid=$patient->persontreated; $dep=DB::table('dependant')->where('id',$depid)->first();
      $dgender=$dep->gender;
      $intervals = date_diff(date_create(), date_create($dep->dob));
      $dage= $intervals->format(" %Y Year, %M Months, %d Days Old");
      ?>
      <td><a href="{{url('nurse.dependents',$dep->id)}}">{{$i}}</a></td>
      <td><a href="{{url('nurse.dependents',$dep->id)}}">{{$dep->firstName}} {{$dep->secondName}}</a></td>
      <td><a href="{{url('nurse.dependents',$dep->id)}}">{{$dgender}}</a></td>
      <td><a href="{{url('nurse.dependents',$dep->id)}}">{{$dage}}</a></td>
      <td><a href="{{url('nurse.dependents',$dep->id)}}">{{$patient->created_at}}</a></td>

    @endif
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
