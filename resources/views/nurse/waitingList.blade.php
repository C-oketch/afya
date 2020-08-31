
@extends('layouts.nurse')
@section('title', 'Waiting patients')
@section('content')
  <div class="content-page  equal-height">
     
      <div class="content">
          <div class="container">

<?php
use Carbon\Carbon;
$current = Carbon::now();


 ?>

 <div class="wrapper wrapper-content animated fadeInRight">
           <div class="row">
              <div class="col-lg-10 col-lg-offset-1">
               <div class="ibox float-e-margins">
                   <div class="ibox-title">
                       <h5>Waiting list</h5>
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
                                                          <th> No</th>
                                                          <th> Name</th>
                                                          <th>Gender</th>
                                                          <th> Age</th>
                                                        <th>Time waited to see the doctor</th>
                                                    </tr>
                                                  </thead>


                                                  <tbody>
                                                    <?php $i =1; ?>
                                                 @foreach($patients as $patient)
                                                      <tr>
                                                          <td>{{$i}}</td>
                                                          <td>{{$patient->firstname}} {{$patient->secondName}}</a></td>

                                                          <td><?php $gender=$patient->gender;?>
                                                            @if($gender==1){{"Male"}}@else{{"Female"}}@endif</a>
                                                          </td>
                                                          <td>{{$patient->age}}</td>

                                                          <td><?php $startTime = Carbon::parse($patient->dateCreated);
                                                             $finishTime = Carbon::parse($current);

                                                             $totalDuration = $finishTime->diffForHumans($startTime,true);

                                                               ?>
                                                              	{{$totalDuration}}
                                                              </td>



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
