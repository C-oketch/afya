@extends('layouts.doctor_layout')
@section('title', 'Self Reporting')
@section('content')
  <div class="content-page  equal-height">
      <div class="content">
          <div class="container">
            <?php
            $doc = (new \App\Http\Controllers\DoctorController);
            $Docdatas = $doc->DocDetails();
            foreach($Docdatas as $Docdata){
            $Did = $Docdata->id;
            $Name = $Docdata->name;
          }

            ?>

  <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-11">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Self Reporting</h5>
                        <div class="ibox-tools">
                          @role('Doctor')
                           <a class="collapse-link">
                            {{$Name}}
                          </a>  @endrole
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
                                  <th>Age</th>
                                  <th>Gender</th>
                                  <th>Residence</th>
                                  <th>Date</th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php  $i =1;?>
                            @foreach($patients as $apatient)
                            <?php

                             if ($apatient->dependents=='Self'){
                            $name = $apatient->firstname." ".$apatient->secondName;
                            $gender=$apatient->gender;
                            $dob=$apatient->dob;
                            if($gender==1){$gender ="Male";}else{$gender ="Female";}
                            $link='afyauslfrprtng';
                             }else {
                             $name = $apatient->Infname." ".$apatient->InfName;
                            $gender=$apatient->Infgender;
                            $dob=$apatient->Infdob;
                            $link='depslfrprtng';


                            }

                            $interval = date_diff(date_create(), date_create($dob));
                            $age= $interval->format(" %Y Ys, %M Ms, %d Ds Old");

                              ?>
                            <tr>
                              <td><a href="{{route($link,$apatient->id)}}">{{$i}}</a></td>
                              <td><a href="{{route($link,$apatient->id)}}">{{$name}}</a></td>
                              <td><a href="{{route($link,$apatient->id)}}">{{$age}}</a></td>
                              <td><a href="{{route($link,$apatient->id)}}">{{$gender}}</a></td>
                              <td><a href="{{route($link,$apatient->id)}}">{{$apatient->Constituency}}</a></td>
                              <td><a href="{{route($link,$apatient->id)}}">{{$apatient->srpdate}}</a></td>

                           </tr>
                            <?php $i++; ?>
                          @endforeach

                        </tbody>


                     </tbody>
                   </table>
                       </div>

                   </div>
               </div>
           </div>
           </div>
       </div>
       @include('includes.default.footer')

         </div><!--container-->
      </div><!--content-->
      </div><!--content page-->

@endsection
