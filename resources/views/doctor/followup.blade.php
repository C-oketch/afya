@extends('layouts.doctor')
  @section('content')
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
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
<!-- <input name="b_print" type="button" class="ipt"   onClick="printdiv('div_print12');" value=" Print ">
<div id="div_print12">
vintage
</div> -->




<!-- <input name="b_print" type="button" class="ipt"   onClick="printdiv('div_print');" value=" Print "> -->
<div id="div_print">

            <div class="ibox-title">
                <h5>Patients List</h5>

                <div class="ibox-tools">
                    <a class="collapse-link">
                        {{$Name}}
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
<th>Last Visit Date</th>
</tr>
</thead>
<tbody>
<?php $i =1; ?>
@foreach($patients as $patient)
<?php
$lastvisitdate=DB::table('appointments')->where('id', $patient->last_app_id)->first();

  ?>
<tr>
@if($patient->persontreated==="Self")
<td><a href="{{route('showPatient',$patient->appid)}}">{{$i}}</a></td>
<td><a href="{{route('showPatient',$patient->appid)}}">{{$patient->first}} {{$patient->second}}</a></td>
<td><?php $gender=$patient->gender;?>
{{$gender}}</a>
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
{{$gender}}</a>
</td>
<td><?php
$ddob=$patient->ddob;
$intervals = date_diff(date_create(), date_create($patient->ddob));
$dage= $intervals->format(" %Y Year, %M Months, %d Days Old");?>
{{$dage}}
</td>
@endif
<td>{{$patient->created_at}}</td>
<td>{{$lastvisitdate->created_at}}</td>
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
@endsection
