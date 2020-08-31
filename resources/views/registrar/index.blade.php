@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')

  @include('includes.registrar.topnavbar_v1')

  <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
              <div class="col-lg-11">
              <div class="ibox float-e-margins">
              <div class="ibox-title">
                    <h5>Today's Patients.</h5>
              </div>

              <div class="ibox-content">

        <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover dataTables-example" >
              <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Phone No.</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Appointment</th>
                    <th>Constituency of Residence</th>
                    <th>County of Residence</th>

                      </tr>
                    </thead>

                    <tbody>
                      <?php $i=1; ?>
                      @foreach($usersappointment as $user)
                    <tr>
                    <td><a href="{{URL('registrar.showsapp',$user->appid)}}">{{$i}}</a></td>
                    <td style="width:100px"><a href="{{URL('registrar.showsapp',$user->appid)}}">{{$user->firstname}} {{$user->secondName}}</a></td>
                    <?php
                      $in = $user->msisdn;
                      $result =  str_replace("254","0",$in);
                      ?>
                    <td><a href="{{URL('registrar.showsapp',$user->appid)}}">{{$result}}</a></td>
                    <?php
                    $interval = date_diff(date_create(), date_create($user->dob));
                    $age1 = $interval->format(" %Y Yrs");
                     ?>
                    <td><a href="{{URL('registrar.showsapp',$user->appid)}}">{{$age1}}</a></td>
                    <td><a href="{{URL('registrar.showsapp',$user->appid)}}">{{$user->gender}}</a></td>

                    <td style="width:75px"><a href="{{URL('registrar.showsapp',$user->appid)}}">
                      <?php $dt=$user->appointment_date; echo date("d-m-Y ", strtotime( $dt));?>
                    </a></td>
                    <td><a href="{{URL('registrar.showsapp',$user->appid)}}">{{$user->appointment_time}} </a></td>
                    <td><a href="{{URL('registrar.showsapp',$user->appid)}}">YES </a></td>
                    <td><a href="{{URL('registrar.showsapp',$user->appid)}}">{{$user->Constituency or ''}}</a></td>
                    <td><a href="{{URL('registrar.showsapp',$user->appid)}}">{{$user->county or ''}}</a></td>

                        </tr>
                          <?php $i++; ?>
                       @endforeach
                       <?php $i=$i; ?>
                       @foreach($users as $user)
                       <tr>
                       <td><a href="{{URL('registrar.selects',$user->id)}}">{{$i}}</a></td>
                       <td style="width:100px"><a href="{{URL('registrar.selects',$user->id)}}">{{$user->firstname}} {{$user->secondName}}</a></td>
                       <?php  $in = $user->msisdn;
                             $result =  str_replace("254","0",$in);  ?>
                       <td><a href="{{URL('registrar.selects',$user->id)}}">{{$result}}</a></td>
                       <?php
                       $interval = date_diff(date_create(), date_create($user->dob));
                       $age1 = $interval->format(" %Y Yrs");
                       ?>
                       <td><a href="{{URL('registrar.selects',$user->id)}}">{{$age1}}</a></td>
                       <td><a href="{{URL('registrar.selects',$user->id)}}">{{$user->gender}}</a></td>

                       <td style="width:75px"><a href="{{URL('registrar.selects',$user->id)}}">N/A</a></td>
                       <td style="width:75px"><a href="{{URL('registrar.selects',$user->id)}}">N/A</a></td>
                       <td><a href="{{URL('registrar.selects',$user->id)}}">N/A</a></td>
                       <td><a href="{{URL('registrar.selects',$user->id)}}">{{$user->Constituency or ''}}</a></td>
                       <td><a href="{{URL('registrar.selects',$user->id)}}">{{$user->county or ''}}</a></td>

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

@endsection
