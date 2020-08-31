@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')
<?php
$patient=DB::Table('kin_details')->where('afya_user_id',$user->id)->first();
$kin = DB::table('kin')->get();
$countys=DB::Table('constituency')
->where('id',$user->constituency)
->first();
?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-md-12">
     <br /><br />
      <div class="col-md-4">
        <address>
        <strong>PATIENT BASIC INFO:</strong><br>
        <strong>Name : </strong>{{$user->firstname}}  {{$user->secondName}}<br>
        <strong>Gender : </strong>{{$user->gender}}<br>
        <strong>Age: </strong>{{$user->dob}}<br>
        <strong>pob: </strong>{{$user->pob}}<br>
        <strong>Id: </strong>{{$user->nationalId}}<br>
      <strong>  NHIF: </strong>{{$user->nhif}}
      </address>
      </div>
      @if($patient)
      <div class="col-md-4">
        <address>
          <strong>Next Of Kin Details : </strong><br>
          <strong>Name: </strong>{{$patient->kin_name}}<br>
          <strong>Relation : </strong><?php $relate = DB::Table('kin')->where('id',$patient->relation)->first();?>{{$relate->relation}}<br>
          <strong>Phone : </strong>{{$patient->phone_of_kin}} <br />
          <strong>Postal Address : </strong>{{$patient->postal}} <br /> <br />
      </address>
      </div>
      @endif

      <div class="col-md-4 ">
        <address>
          <strong>Contact Details :</strong><br>
          <strong>Phone :</strong> {{$user->msisdn}}<br>
          <strong>Email :</strong> {{$user->email}}<br>
          <strong>Constituency :</strong> {{$countys->Constituency }}
      </address>
      </div>

    </div>
</div>
<?php $patient=DB::Table('kin_details')->where('id',$id)->first(); ?>

<div class="row">
  <br />
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Next Of Kin Update form</h5>
                        </div>
                        <div class="ibox-content">
                              <form class="form-inline" role="form" method="POST" action="/registrarupdatekin" >
                             <input type="hidden" name="_token" value="{{ csrf_token() }}">
                             <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$id}}" name="id"  required>
                             <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$patient->afya_user_id}}" name="userid"  required>


                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="name" class="form-control"  value="{{$patient->kin_name}}" name="kin_name"   required>
                                  </div>
                                <div class="form-group">
                                 <label>Relationship</label>
                                <select class="form-control" name="relationship" required="">
                                  <?php
                                  $relationship = DB::table('kin_details')
                                            ->join('kin', 'kin.id', '=','kin_details.relation')
                                            ->select('kin.relation','kin.id')
                                            ->where('kin_details.id', '=', $id)
                                            ->first();
                                   ?>
                                <option value="{{$relationship->id}}" selected >{{$relationship->relation}}</option>
                                <?php
                                $kin = DB::table('kin')
                                      ->where('id', '<>', $relationship->id)
                                      ->get();
                                ?>
                                              @foreach($kin as $kn)
                                               <option value="{{$kn->id}}">{{$kn->relation}}</option>
                                             @endforeach
                                            </select>
                                </div>

                                 <div class="form-group">
                                <label>Phone</label>
                                <input type="number" class="form-control"  value="{{$patient->phone_of_kin}}" name="phone"  required>
                                </div>

                                <div class="form-group">
                               <label for="exampleInputPassword1">Postal Address</label>
                               <input type="text" class="form-control" value="{{$patient->postal}}" name="postal"   />
                               </div>

                               <button type="submit" class="btn btn-primary btn-sm pull-right">Update Details</button>
                                  {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                </div>
@endsection
