@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Collect Fees</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Home</a>
            </li>

            <li class="active">
                <strong>Fees</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-4">

    </div>
</div>

  <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-11">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All Fees</h5>
                        <div class="ibox-tools">

                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>First Name</th>
                            <th>Second Name</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Visit Date</th>
                            <th>Fee Type</th>


                      </tr>
                    </thead>

                    <tbody>
                      <?php $i=1;?>
            @foreach($patients as $fee)

            <tr>
            <td><a href="{{URL('register.feespay',$fee->id) }}" >{{$i}}</a></td>
            <td><a href="{{URL('register.feespay',$fee->id) }}" >{{$fee->firstname}} </a></td>
            <td><a href="{{URL('register.feespay',$fee->id) }}" >{{$fee->secondName}}</a></td>
            <td><a href="{{URL('register.feespay',$fee->id) }}" >{{$fee->msisdn}}</a> </td>
            <td><a href="{{URL('register.feespay',$fee->id) }}" >{{$fee->gender}}</a> </td>
            <td><a href="{{URL('register.feespay',$fee->id) }}" >{{$fee->created_at}}</a></td>
            <td><a href="{{URL('register.feespay',$fee->id) }}" >Consultation Fees</a></td>

          </tr>
          <?php $i++ ?>
            @endforeach
<?php
$facilitypath = DB::table('facility_registrar')
               ->join('facilities', 'facilities.FacilityCode', '=', 'facility_registrar.facilitycode')
               ->select('facilities.payment')
               ->where('facility_registrar.user_id', Auth::user()->id)
               ->first();
               $path = $facilitypath->payment;

?>
@if($path == 'nguchu')
            @foreach($labtest as $fee1)
            <tr>
            <td><a href="{{URL('register.feespaytest',$fee1->id) }}" >{{$i}}</a></td>
            <td><a href="{{URL('register.feespaytest',$fee1->id) }}" >{{$fee1->firstname}} </a></td>
            <td><a href="{{URL('register.feespaytest',$fee1->id) }}" >{{$fee1->secondName}}</a></td>
            <td><a href="{{URL('register.feespaytest',$fee1->id) }}" >{{$fee1->msisdn}}</a> </td>
            <td><a href="{{URL('register.feespaytest',$fee1->id) }}" >{{$fee1->gender}}</a> </td>
            <td><a href="{{URL('register.feespaytest',$fee1->id) }}" >{{$fee1->created_at}}</a></td>
            <td><a href="{{URL('register.feespaytest',$fee1->id) }}" >Lab Test Fees</a></td>
            </tr>


            <?php $i++ ?>
  @endforeach
  @foreach($rady as $fee2)


  <tr>
  <td><a href="{{URL('register.feespaytest2',$fee2->appid) }}" >{{$i}}</a></td>
  <td><a href="{{URL('register.feespaytest2',$fee2->appid) }}" >{{$fee2->firstname}} </a></td>
  <td><a href="{{URL('register.feespaytest2',$fee2->appid) }}" >{{$fee2->secondName}}</a></td>
  <td><a href="{{URL('register.feespaytest2',$fee2->appid) }}" >{{$fee2->msisdn}}</a> </td>
  <td><a href="{{URL('register.feespaytest2',$fee2->appid) }}" >{{$fee2->gender}}</a> </td>
  <td><a href="{{URL('register.feespaytest2',$fee2->appid) }}" >{{$fee2->created_at}}</a></td>
  <td><a href="{{URL('register.feespaytest2',$fee2->appid) }}" >Radiology Test Fees</a></td>
  </tr>
  <?php $i++ ?>
@endforeach
@endif
 </tbody>

                   </table>
                       </div>

                   </div>
               </div>
           </div>
           </div>
       </div>

             @include('includes.admin_inc.footer')

@endsection
