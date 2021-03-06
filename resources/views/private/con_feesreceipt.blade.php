@extends('layouts.private')
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
              <!-- <a href="#" class="btn btn-white"><i class="fa fa-pencil"></i> Edit </a>
              <a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save </a> -->
              <a href="{{ URL::to('private.fees') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </a>
              <input name="b_print" type="button" class="btn btn-primary"   onClick="printdiv('div_print');" value=" Print ">
          </div>
      </div>
  </div>
    <div id="div_print">
   <div id="wrapper">
<?php

$datetime = explode(" ",$receipt->appointment_date);
$dateaap = $datetime[0];
?>

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
                              <strong>Next Appointment</strong><br>
                              <strong>Date:</strong> {{$dateaap}}<br>
                              <strong>Time:</strong> {{$receipt->appointment_time}}<br>
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
                @if($receiptcon)<h4 class="text-navy"><strong>Receipt No:</strong>
                      <?php $year = date("y"); ?>
                    {{$receiptcon->the_id}}{{$year}}</h4> @endif

                      <address>

                        <strong>Facility :</strong>  {{$receipt->FacilityName}}<br>
                        <strong>Doctor :</strong>  {{$receipt->doc_name}}<br>

                      </address>
                      <p>
                        <?php

                        $date = new DateTime($receiptcon->created_at);

                        ?>
                          <span><strong>Date:</strong> {{$date->format('Y-m-d')}}</span>
                      </p>
                  </div>
              </div>

                <div class="table-responsive m-t">
                    <table class="table invoice-table">
                        <thead>
                          <tr>
                              <th>Description of Service</th>
                              <th>Total </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                              <td>{{$receiptcon->category_name}}</td>
                              <td>{{$receiptcon->amount}}</td>
                          </tr>
                        </tbody>
                    </table>
                </div><!-- /table-responsive -->

                <table class="table invoice-total">
                    <tbody>
                    <tr>
                        <td><strong>TOTAL :</strong></td>
                       <td>{{$receiptcon->amount}}</td>
                    </tr>
                    </tbody>
                </table>

                <div class="bottom-div"><i>With thanks.</i> </div>


            </div>

    </div>

    </div>
  </div><!--wrapper-->

             @include('includes.admin_inc.footer')

@endsection
