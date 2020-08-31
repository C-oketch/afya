@extends('layouts.private')
@section('title', 'Dashboard')
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
                                                    <?php $i =1; ?>
                                                 @foreach($patients as $patient)
                                                      <tr>
                                                @if($patient->persontreated==="Self")
                                  <td><a href="{{route('showPatient',$patient->appid)}}">{{$i}}</a></td>
                                    <td><a href="{{route('showPatient',$patient->appid)}}">{{$patient->first}} {{$patient->second}}</a></td>
                                    <td><?php $gender=$patient->gender;?>
                                      @if($gender==1){{"Male"}}@else{{"Female"}}@endif</a>
                                    </td>
                                  <td><?php $dob=$patient->dob;
                                  $interval = date_diff(date_create(), date_create($dob));
                             $age= $interval->format(" %Y Year, %M Months, %d Days Old");?> {{$age}}

                             </td>
                              @else
                              <td><a href="{{route('showPatient',$patient->appid)}}">{{$i}}</a></td>
                              <td><a href="{{route('showPatient',$patient->appid)}}">{{$patient->dfirst}} {{$patient->dsecond}}</a></td>
                              <td>
                                <?php $gender=$patient->dgender;?>
                                @if($gender==1){{"Male"}}@else{{"Female"}}@endif</a>

                              </td>
                              <td><?php
                              $ddob=$patient->ddob;
                              $intervals = date_diff(date_create(), date_create($patient->ddob));
                              $dage= $intervals->format(" %Y Year, %M Months, %d Days Old");?>

                              {{$dage}}</td></td>

                              @endif



                                                          <td>{{$patient->created_at}}</td>



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
