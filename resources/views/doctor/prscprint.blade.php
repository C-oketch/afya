@extends('layouts.doctor_layout')
@section('title', 'Prescriptions')

@section('content')

<?php

    $afyauserId=$receipt->afyaId;
    $app_id=$receipt->appid;
    $condition =$receipt->condition;
     ?>
@section('leftmenu')
@include('includes.doc_inc.leftmenu2')
@endsection

<div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
          <h2>Prescriptions</h2>
          <!-- <ol class="breadcrumb">
              <li>
                  <a href="index.html">Home</a>
              </li>
              <li>
                  Fees
              </li>
              <li class="active">
                  <strong>Patient Invoice</strong>
              </li>
          </ol> -->
      </div>
      <div class="col-lg-4">
          <div class="title-action">
              <a href="{{ URL::to('doctor.prescriptions',$receipt->appid) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </a>
              <input name="b_print" type="button" class="btn btn-primary"   onClick="printdiv('div_print');" value=" Print ">

          </div>
      </div>
  </div>
  <div class="row wrapper">
  <div id="div_print">
   <div id="wrapper">


            <div class="wrapper wrapper-content p-xl">
                <div class="ibox-content p-xl">
                  <div class="row">

                      <div class="col-sm-4">
                           <address>
                             @if($receipt->persontreated == 'Self')
                              <strong>Patient:</strong> {{$receipt->firstname}} {{$receipt->secondName}}<br>
                              @else
                              <strong>Patient:</strong> {{$receipt->dep_fname}} {{$receipt->dep_lname}}<br>
                              @endif

                              @if(isset($receipt->appointment_date))
                              <strong>Next Appointment Date:</strong> {{$receipt->appointment_date}}<br>
                              @endif
                          </address>
                      </div>
                      <div class="col-sm-4">
                      <?php  $id = Auth::id();
                        $image = DB::table('facility_doctor')
                        ->leftjoin('logo_imgs', 'facility_doctor.facilitycode', '=', 'logo_imgs.facility')
                        ->select('logo_imgs.id','logo_imgs.directory','facility_doctor.facilitycode')
                        ->where('facility_doctor.user_id', '=',$id)->first();
                         ?>
                        @if($image)
                        <!-- <img alt="image" class="img-circle" src="{{ asset("/img/logos/$image->directory") }}" height="200" width="200"/> -->
                        @endif
                        </div>
                  <div class="col-sm-4 text-right">
                      <h4 class="text-navy"><strong>Prescription No:</strong>
                      <?php $year = date("y"); ?>  @if($prb){{$prb->id}}{{$year}} @endif</h4>

                      <address>

                        <strong>Facility :</strong>  {{$receipt->FacilityName}}<br>
                        <strong>Doctor :</strong>  {{$receipt->doc_name}}<br>
                        <strong>{{$receipt->subspeciality}}</strong>  <br>

                      </address>
                @if($prb)      <p>
<?php
$timestamp = $prb->created_at;
$datetime = explode(" ",$timestamp);
$date = $datetime[0];
?>
                          <span><strong>Date:</strong>{{$date}} </span>
                      </p>@endif
                  </div>
              </div>
                <div class="table-responsive m-t">
                    <table class="table">
                        <thead>
                          <tr>
                              <th>Drug Details</th>
                              <!-- <th>Instructions</th> -->

                          </tr>
                        </thead>
                        <tbody>
                      @foreach($presczs as $feer)

                          <tr>
                             <td>{{$feer->drug_id}}</td>
                          <!-- <td>{{$feer->note}}</td> -->
                          </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /table-responsive -->

                <table class="table invoice-total">
                    <tbody>
                    <tr>
                        <td><strong>sign :</strong></td>
                       <td></td>
                    </tr>
                    </tbody>
                </table>

                <div class="bottom-div"><i>With thanks.</i> </div>
            </div>
    </div>
  </div><!--wrapper-->
  </div>
</div>
@endsection
<!-- Section Body Ends-->
@section('script-test')

@endsection
