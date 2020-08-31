@extends('layouts.facilityadmin')
@section('title', 'Dashboard')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-8">
                  <h2>Facility Registrars</h2>
                  <ol class="breadcrumb">
                      <li>
                          <a href="#">Home</a>
                      </li>

                      <li class="active">
                          <strong>All registers</strong>
                      </li>
                  </ol>
              </div>
              <div class="col-lg-4">
                  <div class="title-action">
                      <!-- <a href="#" class="btn btn-white"><i class="fa fa-pencil"></i> Edit </a>
                      <a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save </a> -->
                      <a href="{{ URL::to('addfacilityregister') }}" class="btn btn-primary"><i class="fa fa-print"></i> Add Registrar </a>
                  </div>
              </div>
          </div>

<div class="row wrapper border-bottom">
  <div class="row">

<div class="col-sm-11">
                 <div class="panel-body">
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
<th>RegNo</th>
<th>Name</th>
<th>Facility Name</th>
<!-- <th>Practice</th> -->
<th>Type</th>
<th>County</th>
<th>Constituency</th>
<th>Ward</th>
</tr>
</thead>
<tbody>
<?php   $i=1;  ?>
@foreach ($facilities as $fact)
<tr>
<td>{{$i}}</td>
<td>{{$fact->regno}}</td>
<td>{{$fact->name}}</td>
<td>{{$fact->FacilityName}}</td>

<td>{{$fact->Type}}</td>
<td>{{$fact->County}}</td>
<td>{{$fact->Constituency}}</td>
<td>{{$fact->Ward}}</td>
</tr>
<?php $i++;  ?>
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


@endsection
