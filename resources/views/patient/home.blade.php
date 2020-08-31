@extends('layouts.patient')
@section('title', 'Patient')
@section('content')
<?php $const= $patient->constituency; $cons=DB::table('constituency')->where('id',$const)->first();
          if($const){ $county=DB::Table('county')->where('id',$cons->cont_id)->first(); }

if($patient->gender){ $gender = $patient->gender; }else{ $gender = 'unknown';}
if($patient->blood_type){ $blood = $patient->blood_type; }else{ $blood = 'unknown';}
if($patient->pob){ $pob = $patient->pob; }else{ $pob = 'unknown';}
if($patient->nationalId){ $nid = $patient->nationalId; }else{ $nid = 'unknown';}
if($patient->nhif){ $nhif = $patient->nhif; }else{ $nhif = 'unknown';}

if($patient->dob){
  $dob = $patient->dob;
  $interval = date_diff(date_create(), date_create($dob));
  $age= $interval->format(" %Y Year, %M Months, %d Days Old");
  }else{ $dob = 'unknown';
         $age = 'unknown';   }
if($patient->msisdn){ $phone  = $patient->msisdn; }else{ $phone  = 'unknown';}
if($patient->email){ $email = $patient->email; }else{ $email = 'unknown';}

          ?>
          <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                  <h2>Profile</h2>
                  <ol class="breadcrumb">
                      <li>
                          <a href="#">Home</a>
                      </li>
                      <li class="active">
                          <strong>Profile</strong>
                      </li>
                  </ol>
              </div>
              <div class="col-lg-2">

              </div>
          </div>
          <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
              <div class="col-md-4">

                            <h2>{{$patient->firstname}} {{$patient->secondName}}</h2>
                            <!-- <h4>Patient</h4> -->
                            <address class="pull-left">
                          <strong>Contact Details : </strong><br>
                        Phone : <strong>{{$phone}} </strong><br>
                        Email : <strong>{{$email}} </strong><br>
                      Constituency :  @if($const){{$cons->Constituency}}@else <strong>uknown</strong> @endif
                      </address>
                      </div>
            <div class="col-md-4">
              <br /><br />
                <table class="table small m-b-xs">
                    <tbody>
                    <tr>
                        <td><strong>{{$age}} : </strong> Age</td>
                        <td><strong>{{$gender}} : </strong> Gender</td>
                    </tr><tr>
                      <td><strong>{{$blood}} : </strong> Blood Type</td>
                      <td><strong>{{$pob}} : </strong> Place Of Birth</td>
                    </tr>
                    <tr>
                      <td><strong>{{$dob}} : </strong> Date of Birth</td>
                      <td><strong>{{$nid}} : </strong> National ID</td>

                    </tr>
                    <tr>
                      <td colspan="2"><strong>{{$nhif}} : </strong> NHIF NO</td>
                    </tr>

                    <tr>
                      <td colspan="2"><a href="{{route('patientdtls',$patient->id)}}" class="btn btn-block btn-outline btn-primary pull-center">Update Details</a>
                       </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
              <address>
                <br /><br />
            <strong>Next Of Kin Details : </strong><br>
            @if($nextkin)

          Name : <strong>{{$nextkin->kin_name}} </strong><br>
          Relation : <strong>{{$nextkin->relation}}</strong><br>
          Phone : <strong>{{$nextkin->phone_of_kin}}</strong>
        @else
        No data Available
         @endif
        </address>

        <address>

      <strong>LOGIN Details : </strong><br>
    Username : <strong>{{ $credentials->name}} </strong><br>
    Role : <strong>{{ $credentials->role}} </strong><br>
    Email/Phone :<strong>{{ $credentials->email}} </strong><br>
    Pasword : <strong>*******</strong><br>

  </address>
  <a href="{{route('crdents',$credentials->id)}}">Change Credentials</a>

        </div>
</div>

</div>




@endsection
