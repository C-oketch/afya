@extends('layouts.patient')
@section('title', 'Patient')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">

  <?php

$user=DB::table('afya_users')->where('users_id',$id)->first();

  $dependants=DB::table('dependant')
  ->join('dependant_parent', 'dependant_parent.dependant_id', '=', 'dependant.id')
  ->select('dependant.*', 'dependant_parent.relationship AS relationship')
  ->where('dependant_parent.afya_user_id',$user->id)
  ->get();
  ?>

     <div class="col-lg-10 col-sm-offset-1" style="text-align:left;">
    <div class="ibox-title">
        <h5>Dependant Details</h5>
</div>
<div class="ibox-content">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-example" >
      <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Gender</th>
          <th>Relationship</th>
          <th>Date of Birth</th>
          <th>Place of Birth</th>
        </tr>
      </thead>


      <tbody>
        <?php $i=1; ?>

        @foreach($dependants as $dependant)

        <tr>
          <td><a href="{{URL('patient.dependantself',$dependant->id)}}">{{$i}}</a></td>
          <td><a href="{{URL('patient.dependantself',$dependant->id)}}">{{$dependant->firstName}} {{$dependant->secondName}}</a></td>
          <td>{{$dependant->gender}}</td>
          <td>{{$dependant->relationship}}</td>
          <td>{{$dependant->dob or ''}}</td>
          <td>{{$dependant->pob or ''}}</td>


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




@endsection
