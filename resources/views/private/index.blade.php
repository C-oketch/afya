@extends('layouts.doctor_layout')
@section('title', 'Dashboard')
@section('content')

@section('leftmenu')
@include('includes.private_inc.leftmenu')
@endsection
@include('includes.doc_inc.topnavbar_v1')


<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h4>Waiting List</h4>

        </div>
        <div class="ibox-content">


          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>File No</th>
                  <th>Gender</th>
                  <th>Age</th>
                  <th>Visit Status</th>
                  <th>Appointment Date</th>
                </tr>
              </thead>

              <tbody>
                <?php $i =1; ?>
                @foreach($patients as $patient)
                <tr>

                  <td><a href="{{route('private.show',$patient->appid)}}">{{$i}}</a></td>
                  <td><a href="{{route('private.show',$patient->appid)}}">{{$patient->first}} {{$patient->second}}</a></td>
                  <td>{{$patient->fileno}}</td>
                  <td>{{$patient->gender}}</td>
                  <td><?php $dob=$patient->dob;
                  $interval = date_diff(date_create(), date_create($dob));
                  $age= $interval->format(" %Y Years");?> {{$age}}

                </td>


                <?php
                if ($patient->last_app_id){
                  $appdt = DB::table('appointments')
                  ->select('appointment_date')->where('id', $patient->last_app_id)
                  ->first();
                  if ($appdt->appointment_date) {$appointment = $appdt->appointment_date;}else{ $appointment ='None'; }
                }else{ $appointment ='None'; }
                ?>
                <td>{{$patient->visit_type}}</td>
                <td>{{$appointment}}</td>



              </tr>
              <?php $i++; ?>

              @endforeach

              <?php $i =$i; ?>
              @foreach($patients2 as $patient)
              <tr>
                @if($patient->persontreated==="Self")
               <td><a href="{{route('private.show',$patient->appid)}}">{{$i}}</a></td>
                <td><a href="{{route('private.show',$patient->appid)}}">{{$patient->first}} {{$patient->second}}</a></td>

                <td>{{$patient->fileno}}</td>
                <td>{{$patient->gender}}</td>
                <td><?php $dob=$patient->dob;
                $interval = date_diff(date_create(), date_create($dob));
                $age= $interval->format(" %Y Years");?> {{$age}}

              </td>
              @else
              <!-- dependants data---------------------->

              <td><a href="{{route('showPatient',$patient->appid)}}">{{$i}}</a></td>
              <td><a href="{{route('showPatient',$patient->appid)}}">{{$patient->dfirst}} {{$patient->dsecond}}</a></td>

              <td><?php $gender=$patient->dgender;?>
                @if($gender==1){{"Male"}}@else{{"Female"}}@endif</a>
              </td>
              <td><?php
              $ddob=$patient->ddob;
              $intervals = date_diff(date_create(), date_create($patient->ddob));
              $dage= $intervals->format(" %Y Year, %M Months, %d Days Old");?>
              {{$dage}}</td></td>
              @endif
              <?php
              if ($patient->last_app_id){
                $appdt = DB::table('appointments')
                ->select('appointment_date')->where('id', $patient->last_app_id)
                ->first();
                if ($appdt->appointment_date) {$appointment = $appdt->appointment_date;}else{ $appointment ='None'; }
              }else{ $appointment ='None'; }
              ?>
              <td>{{$patient->visit_type}}</td>
              <td>{{$appointment}}</td>



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

@include('includes.default.footer')


@endsection
