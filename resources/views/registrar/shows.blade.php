@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('style')

@endsection
@section('content')
@include('includes.registrar.topnavbar_v2')
<?php
$Constituency='';
$patient=DB::Table('kin_details')->where('afya_user_id',$user->id)->first();
$kin = DB::table('kin')->get();
if($user->constituency){
  $countys=DB::Table('constituency')->where('id',$user->constituency)->first();

  $usercounty=$countys->Constituency;
}else{$usercounty=''; }


// dd($appointment);

$afyauserId= $user->id;
$facd = $path->facilitycode;

$tests = DB::table('tests')
->Join('test_price', 'tests.id', '=', 'test_price.tests_id')
->Join('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
->Join('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
->select('tests.id as testId','tests.name as tname','test_subcategories.name as subname',
'test_categories.name as cname')
->where('test_price.facility_id',$facd)
->get();
?>
<div class="container">
  <div class="row">
    <div class="col-md-11">
      <div class="ibox float-e-margins">
        <div class="tab" role="tabpanel">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab">BASIC DETAILS</a></li>

            <li role="presentation" class=""><a href="{{ URL('registrar.shows_test', $appointment) }}" aria-controls="profile" >PATIENT TESTS</a></li>
            <li role="presentation" class=""><a href="{{ URL('registrar.shows_pay', $appointment) }}" aria-controls="messages" role="tab">PAYMENTS</a></li>

            <a href="{{ URL('register_edit_patient', $user->id) }}"  class="btn btn-primary pull-right"><i class="fa fa-print"></i> UPDATE PATIENTS DETAILS </a>

          </ul>


          <!-- Tab panes -->
          <div class="tab-content tabs">
            <div role="tabpanel" class="tab-pane fade in active" id="Section1">
              <div class="row">
                <div class="col-lg-6">
                  <div class="ibox float-e-margins">
                    <div class="ibox-content">
                      <table class="table table-hover no-margins">
                        <thead>
                          <tr>
                            <th colspan="2">PATIENT BASIC INFO</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>  <strong>Name  </strong></td>
                            <td>{{$user->firstname}}  {{$user->secondName}}</td>
                          </tr>
                          <tr>
                            <td><strong>Gender  </strong> </td>
                            <td>{{$user->gender}}</td>
                          </tr>
                          <tr>
                            <td><strong>Date Of Birth </strong></td>
                            <td>{{$user->dob}}</td>
                          </tr>
                          <tr>
                            <td><strong>Place of Birth </strong></td>
                            <td>{{$user->pob}}</td>
                          </tr>
                          <tr>
                            <td><strong>Id </strong></td>
                            <td>{{$user->nationalId}}</td>
                          </tr>


                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="ibox float-e-margins">

                    <div class="ibox-content">
                      <table class="table table-hover no-margins">
                        <thead>
                          <tr>
                            <th colspan="2">Contact Details</th>

                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><strong>Phone </strong> </td>
                            <td>{{$user->msisdn}}</td>
                          </tr>
                          <tr>
                            <td>  <strong>Email </strong> </td>
                            <td>{{$user->email}}</td>
                          </tr>
                          <tr>
                            <td><strong>Constituency </strong> </td>
                            <td>{{$usercounty }}</td>
                          </tr>

                          <tr>
                            <td></td>
                            <td></td>
                          </tr>

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                </div>
                <div class="row">
                <div class="col-lg-6">
                  <div class="ibox float-e-margins">
                    <div class="ibox-content">
                      <table class="table table-hover no-margins">
                        <thead>
                          <tr>
                            <th colspan="2">Insurance Details</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><strong>  NHIF </strong></td>
                            <td>{{$user->nhif}}</td>
                          </tr>
                          @foreach ($insurance as $ins)

                          <tr>
                            <td><strong> INSURER </strong></td>
                            <td>{{$ins->company_name}}</td>
                          </tr>
                          <tr>
                            <td><strong> POLICY NO </strong></td>
                            <td>{{$ins->policy_no}}</td>
                          </tr>
                          @endforeach


                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="ibox float-e-margins">

                    <div class="ibox-content">
                      <table class="table table-hover no-margins">
                        <thead>
                          <tr>
                            <th colspan="2">Next Of Kin Details</th>

                          </tr>
                        </thead>
                        <tbody>
                          @if($patient)
                          <tr>
                            <td><strong>Name </strong></td>
                            <td>{{$patient->kin_name}}</td>
                          </tr>
                          <tr>
                            <td><strong>Relation </strong><br></td>
                            <?php $relate = DB::Table('kin')->where('id',$patient->relation)->first();?>
                            <td>{{$relate->relation}}</td>
                          </tr>

                          <tr>
                            <td><strong>Phone  </strong></td>
                            <td>{{$patient->phone_of_kin}}</td>

                          </tr>
                          <tr>
                            <td></td><td></td>

                          </tr>
                          @endif
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>


                <div>
                </div>
              </div>
</div>

            </div>


          </div>
        </div>
      </div>
    </div>
  </div>


@endsection
  @section('script-reg')
  <!-- Page-Level Scripts -->


  @endsection
