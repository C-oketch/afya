@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')
<br><br><br>
<div class="row">

  <?php
  $dependants=DB::table('dependant')
  ->join('dependant_parent','dependant_parent.dependant_id','=','dependant.id')
  ->select('dependant.*','dependant_parent.relationship AS relationship')
  ->where('dependant_parent.afya_user_id',$id)
  ->get();
  ?>

     <div class="col-lg-11">
    <div class="ibox-title">
        <h5>Dependant Details</h5>
        <div class="ibox-tools">
        <a href="{{URL('registrar.addDependents',$id)}}" class="btn btn-primary btn-block">Add Dependant</a>
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
<th>Relationship</th>
<th>Date of Birth</th>
<th>Place of Birth</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php $i=1; ?>
@foreach($dependants as $dependant)
<tr>
<td><a href="{{URL('registrar.dependantTriage',$dependant->id)}}">{{$i}}</a></td>
<td><a href="{{URL('registrar.dependantTriage',$dependant->id)}}">{{$dependant->firstName}} {{$dependant->secondName}}</a></td>
<td>{{$dependant->gender}}</td>
<td>{{$dependant->relationship or ''}}</td>
<td>{{$dependant->dob or ''}}</td>
<td>{{$dependant->pob or ''}}</td>
<td><a href="{{ url('add-parent?id='.$id.'&dep_id='.$dependant->id)}}" class="btn btn-primary btn-primary">Add Parent/Guardian </a></td>
</tr>
<?php $i++; ?>

@endforeach
</tbody>
</table>

     </div>

     </div>
   </div>
    </div>


@include('includes.default.footer')
</div>


</div>

@endsection
