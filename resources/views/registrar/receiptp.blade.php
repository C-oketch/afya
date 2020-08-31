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
              <!-- <a href="#" class="btn btn-white"><i class="fa fa-pencil"></i> Edit </a>
              <a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save </a> -->
              <a href="{{ URL::to('registrar') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </a>
              <a href="{{route('registrar.print_receipt',$id)}}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice </a>
          </div>
      </div>
  </div>
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
                      {{$receipt->the_id}}{{$year}}</h4>

                      <address>

                        <strong>Facility :</strong>  {{$receipt->FacilityName}}<br>
                        @if($receipt->doc_name)<strong>Doctor :</strong>  {{$receipt->doc_name}}<br>@endif

                      </address>
                      <p>
                        <?php
                        $date = new DateTime($receipt->created_at);

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
                              <td>{{$receipt->category_name}}</td>
                              <td>{{$receipt->amount}}</td>
                          </tr>
                        </tbody>
                    </table>
                </div><!-- /table-responsive -->

                <table class="table invoice-total">
                    <tbody>
                    <tr>
                        <td><strong>TOTAL :</strong></td>
                       <td>{{$receipt->amount}}</td>
                    </tr>
                    </tbody>
                </table>

                <div class="bottom-div"><i>With thanks.</i> </div>


            </div>

    </div>


  </div><!--wrapper-->

      @include('includes.admin_inc.footer')

@endsection
