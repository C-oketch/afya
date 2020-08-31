@extends('layouts.receipt')
@section('title', 'Dashboard')
@section('content')

      <div class="wrapper wrapper-content p-xl">
          <div class="ibox-content p-xl">
                  <div class="row">
                      <div class="col-sm-4">
                           <address>
                             @if($receipt->persontreated == 'Self')
                              <strong>Patient: {{$receipt->firstname}} {{$receipt->secondName}}</strong><br>
                              @else
                              <strong>Patient: {{$receipt->dep_fname}} {{$receipt->dep_lname}}</strong><br>
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

              <div class="bottom-div"><strong><i>With thanks.</i></strong> </div>

          </div>


    </div>

@endsection
