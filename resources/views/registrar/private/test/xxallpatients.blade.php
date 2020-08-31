@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-md-6">
    <address>
      <br />
      <strong>FACILITY :</strong><br>
      <strong> Name :</strong>{{$facilitycode->FacilityName}}<br>
      <strong> Type :</strong> {{$facilitycode->Type}}<br>
    </address>
  </div>
  <div class="col-md-6 text-right">
    <address>
      <br /><br />
      <strong>DATE :</strong><br>
      {{date("l jS \of F Y ")}}
    </address>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-11">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h4>Today Patients</h4>

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
                  <th> Action</th>
                </tr>
              </thead>

              <tbody>
                <?php $i =1; ?>
                @foreach($patients as $patient)
                <tr>
                  @if($patient->persontreated==="Self")

                  <td>{{$i}}</td>
                  <td>{{$patient->first}} {{$patient->second}}</td>
                  <td>{{$patient->gender}}</td>
                  <td><?php $dob=$patient->dob;
                  $interval = date_diff(date_create(), date_create($dob));
                  $age= $interval->format(" %Y Year, %M Months, %d Days Old");?> {{$age}}

                </td>
                @else
                <!-- dependants data---------------------->

                <td>{{$i}}</td>
                <td>{{$patient->dfirst}} {{$patient->dsecond}}</td>
                <td><?php $gender=$patient->dgender;?>
                  @if($gender==1){{"Male"}}@else{{"Female"}}@endif</a>
                </td>
                <td><?php
                $ddob=$patient->ddob;
                $intervals = date_diff(date_create(), date_create($patient->ddob));
                $dage= $intervals->format(" %Y Year, %M Months, %d Days Old");?>
                {{$dage}}</td></td>
                @endif
                <td><a href="{{route('reg.test2',$patient->appid)}}">{{$patient->dfirst}} {{$patient->dsecond}}Add Test</a></td>
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
