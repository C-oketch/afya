@extends('layouts.test')
@section('title', 'Tests')
@section('content')

<div class="container">

<div class="row">

<?php  $dependants=DB::table('dependant')
->join('dependant_parent','dependant_parent.dependant_id','=','dependant.id')
->select('dependant.*','dependant_parent.relationship')->where('dependant_parent.afya_user_id',$id)->get();?>

<div class="col-lg-11">
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
<td><a href="{{URL('test.deppinfo',$dependant->id)}}">{{$i}}</a></td>
<td><a href="{{URL('test.deppinfo',$dependant->id)}}">{{$dependant->firstName}} {{$dependant->secondName}}</a></td>
<td>@if($dependant->gender == 1){{"Male"}}@else{{"Female"}}@endif</td>
<td>{{$dependant->relationship or ''}}</td>
<td>{{$dependant->dob or ''}}</td>
<td>{{$dependant->pob or ''}}</td>


</tr>
<?php $i++; ?>

@endforeach
</tbody>

</table>

</div>
<a href="{{URL('test.addDependents',$id)}}" class="btn btn-primary btn-block">Add Dependant</a>
</div>
</div>
</div>

</div>
@endsection
