@extends('layouts.private')
@section('title', 'Dashboard')
@section('content')
  <div id="wrapper">

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>Patient Invoice</h2>

        </div>
        <div class="col-lg-4">
            <div class="title-action">
                <a href="{{route('private.print_receipt',$id)}}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice </a>
            </div>
        </div>
    </div>

      <div class="wrapper wrapper-content p-xl">
          <div class="ibox-content p-xl">
          <div class="row">
            <div class="col-sm-6">
                 <address>
                   @if($receipt->persontreated == 'Self')
                    <strong>Patient:</strong> {{$receipt->firstname}} {{$receipt->secondName}}<br>
                    @else
                    <strong>Patient:</strong> {{$receipt->dep_fname}} {{$receipt->dep_lname}}<br>
                    @endif
                </address>
            </div>

            <div class="col-sm-6 text-right">
                <h4 class="text-navy"><strong>Receipt No:</strong>
                <?php $year = date("y"); ?>
                {{$receipt->the_id}}{{$year}}</h4>

                <address>

                  <strong>Facility :</strong>  {{$receipt->FacilityName}}<br>
                  <strong>Doctor :</strong>  {{$receipt->doc_name}}<br>

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
                              <th>Description</th>
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
