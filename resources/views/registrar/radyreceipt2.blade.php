@extends('layouts.registrar_layout')
@section('title', 'Dashboard')
@section('content')


<div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
          <h2>Invoice</h2>
          <ol class="breadcrumb">
              <li>
                  <a href="index.html">Home</a>
              </li>
              <li>
                  Fees
              </li>
              <li class="active">
                  <strong>Patient Invoice</strong>
              </li>
          </ol>
      </div>
      <div class="col-lg-4">
          <div class="title-action">
            <a href="{{ URL::to('paid_fees') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </a>

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
          $image = DB::table('facility_registrar')
          ->leftjoin('logo_imgs', 'facility_registrar.facilitycode', '=', 'logo_imgs.facility')
          ->select('logo_imgs.id','logo_imgs.directory','facility_registrar.facilitycode')
          ->where('facility_registrar.user_id', '=',$id)->first();
           ?>
          @if($image)
          <img alt="image" class="img-circle" src="{{ asset("/img/logos/$image->directory") }}" height="200" width="200"/>
          @endif
          </div>
                  <div class="col-sm-4 text-right">
                      <h4 class="text-navy"><strong>Receipt No:</strong>
                      <?php $year = date("y"); ?>
                      R{{$receipt->appid}}{{$year}}</h4>

                      <address>

                        <strong>Facility :</strong>  {{$fac->FacilityName}}<br>
                        <strong>Doctor :</strong>  {{$receipt->doc_name}}<br>

                      </address>
                      <p>
                        <?php
                        // $date = new DateTime($receipt->created_at);

                        ?>
                          <span><strong>Date:</strong> </span>
                      </p>
                  </div>
              </div>
                <div class="table-responsive m-t">
                    <table class="table invoice-table">
                        <thead>
                          <tr>
                              <th>Description of Service</th>
                              <th>Amount </th>
                          </tr>
                        </thead>
                        <tbody>
                      @foreach($rect as $feer)

                      <?php

                      if ($feer->test_cat_id == 9) {
                      $ct =  DB::table('ct_scan')->select('ct_scan.name')->where('id', '=',$feer->test)->first();
                      $name =$ct->name;
                    }elseif($feer->test_cat_id == 10) {
                    $xray =  DB::table('xray')->select('xray.name')->where('id', '=',$feer->test)->first();
                    $name =$xray->name;
                  }elseif($feer->test_cat_id == 11) {
                   $mri =  DB::table('mri_tests')->select('mri_tests.name')->where('id', '=',$feer->test)->first();
                   $name =$mri->name;
                 }elseif($feer->test_cat_id == 12) {
                  $ultra =  DB::table('ultrasound')->select('ultrasound.name')->where('id', '=',$feer->test)->first();
                  $name =$ultra->name;
                 }
                      ?>

                          <tr>
                             <td>{{$name}}</td>
                              <!-- <td>{{$feer->test_cat_id}}</td> -->
                              <td>{{$feer->amount}}</td>
                          </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /table-responsive -->

                <table class="table invoice-total">
                    <tbody>
                    <tr>
                        <td><strong>TOTAL :</strong></td>
                       <td>{{$rectsum->paidsum}}</td>
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
