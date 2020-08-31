@extends('layouts.registrar_layout')
@section('title', 'Dashboard')
@section('content')
@include('includes.registrar.topnavbar_v2')
<?php  $afyauserId= $user->id;?>

<div class="wrapper wrapper-content animated fadeIn">
          <div class="row">
              <div class="col-lg-12">
                  <div class="tabs-container">
                      <ul class="nav nav-tabs">
                          <li class="active"><a data-toggle="tab" href="#tab-1">Test Details</a></li>
                          <li class=""><a data-toggle="tab" href="#tab-2">Prescriptions</a></li>
                          <!-- <li class=""><a data-toggle="tab" href="#tab-3">Receipts</a></li> -->
                          <a href="{{ URL::to('allpatients') }}" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Back </a>

                      </ul>
                      <div class="tab-content">
                        <!-- TEST HISTORY ------------------------------------------------------------>
                 <?php $i=1; ?>
                          <div id="tab-1" class="tab-pane active">
                              <div class="panel-body">
                                  <strong>Patient Test Details</strong>
                                    <div class="table-responsive ibox-content">
                                     <table class="table table-striped table-bordered table-hover dataTables-conditional" >
                                       <thead>
                                         <tr>
                                           <th></th>
                                           <th>Date </th>
                                           <th>Facility</th>
                                           <th>Doctor</th>
                                          <th>Action</th>
                                         </tr>
                                       </thead>
                                  <tbody>
                                  @foreach($tstdone as $tstdn)
                                  <tr>
                                     <td>{{$i}}</td>
                                     <td>{{$tstdn->created_at}}</td>
                                     <td>{{$tstdn->FacilityName}}</td>
                                     <td>{{$tstdn->docname}}</td>
                                     <td><a href="{{url('registrar.testprint',$tstdn->ptid)}}">View</a></td>
                                  </tr>
                                  <?php $i++; ?>
                                  @endforeach
                                  </tbody>
                                  </table>
                                  </div>
                              </div>
                          </div>
                          
  <!-- TEST HISTORY  End Prescription HISTORY  Start ------------------------------------------------------------>
                          <div id="tab-2" class="tab-pane">
                              <div class="panel-body">
                                  <h5>Prescription History</h5>
                                  <div class="table-responsive ibox-content">
                                  <table class="table table-striped table-bordered table-hover dataTables-conditional" >
                                  <thead>
                                    <tr>
                                      <th></th>
                                      <th>Date </th>
                                      <th>Facility</th>
                                      <th>Doctor</th>
                                     <th>Action</th>
                                    </tr>
                                  </thead>

                                  <tbody>
                                  <?php $i =1; ?>

                                  @foreach($prescriptions as $tstdn)
                                  <tr>
                                  <td>{{ +$i }}</td>
                                  <td>{{$tstdn->created_at}}</td>
                                  <td>{{$tstdn->FacilityName}}</td>
                                  <td>{{$tstdn->docname}}</td>
                                  <td><a href="{{route('registrar.prscprint',$tstdn->prescid)}}">View</a></td>
                                  </tr>
                                  <?php $i++; ?>
                                  @endforeach

                                  </tbody>
                                  </table>
                                  </div>

                              </div>
                          </div>
<!-- Prescription HISTORY  End  Receipt start------------------------------------------------------------>
<div id="tab-3" class="tab-pane">
    <div class="panel-body">
        <h5>Prescription History</h5>
        <div class="table-responsive ibox-content">
        <table class="table table-striped table-bordered table-hover dataTables-conditional" >
        <thead>
          <tr>
            <th></th>
            <th>Date </th>
            <th>Facility</th>
            <th>Doctor</th>
           <th>Action</th>
          </tr>
        </thead>

        <tbody>
        <?php $i =1; ?>

        @foreach($prescriptions as $tstdn)
        <tr>
        <td>{{ +$i }}</td>
        <td>{{$tstdn->created_at}}</td>
        <td>{{$tstdn->FacilityName}}</td>
        <td>{{$tstdn->docname}}</td>
        <td><a href="{{route('registrar.prscprint',$tstdn->prescid)}}">View</a></td>
        </tr>
        <?php $i++; ?>
        @endforeach

        </tbody>
        </table>
        </div>

    </div>
</div>
<!-- Receipt End ------------------------------------------------------------>

                      </div>


                  </div>
              </div>
            </div>
            </div>



















@endsection
@section('script-reg')
<script>
$(document).ready(function(){
    $('.dataTables-conditional').DataTable({
        pageLength: 5,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'ExampleFile'},
            {extend: 'pdf', title: 'ExampleFile'},
            {extend: 'print',
             customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
            }
            }
        ]
    });
});
</script>
@endsection
