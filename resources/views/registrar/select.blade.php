@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')
<?php
$facility = DB::table('facility_registrar')
->join('facilities', 'facilities.FacilityCode', '=', 'facility_registrar.facilitycode')
->select('facility_registrar.facilitycode','facilities.set_up')
->where('facility_registrar.user_id', Auth::user()->id)
->first();
$facilitycode = $facility->facilitycode;
$setup = $facility->set_up;

$user=DB::table('afya_users')
->Join('dependant_parent', 'afya_users.id', '=', 'dependant_parent.afya_user_id')
->Join('dependant', 'dependant_parent.dependant_id', '=', 'dependant.id')
->select('dependant.id','dependant.firstName','dependant.secondName')
->where('afya_users.id', $id)->get();

$afyauser=DB::table('afya_users')
->select('firstname','secondName')
->where('afya_users.id', $id)->first();

$doc = DB::table('facility_doctor')
              ->join('doctors', 'facility_doctor.doctor_id', '=','doctors.id' )
              ->select('doctors.name','doctors.id')
              ->where('facility_doctor.facilitycode', '=', $facilitycode)
               ->first();

?>

<div class="wrapper wrapper-content animated fadeInRight">


   @if(!empty($facilitycode) && $setup == 'Partial')

    <div class="row col-md-12">
    <div class="ibox float-e-margins">
    <div class="ibox-title">
    <h5>Person To Be Treated</h5>
    </div>
    <div class="ibox-content">
    <h3 class="m-t-none m-b"></h3>
    {!! Form::open(array('url' => 'registrar.shows','method'=>'POST')) !!}
<div class="form-group">
  <label class="col-sm-3 control-label"></label>
<div class="col-sm-9">
  <label class="checkbox-inline"> <input type="radio" value="Self" id="treated1" name="treated" onclick="self1();" required>Self</label>
  <label class="checkbox-inline"><input type="radio" value="Dependant" id="treated2" name="treated" onclick="depnd1();" required>Dependant</label>
</div>
</div>



<div class="form-group ficha" id="self2">
<label class="control-label" for="name">Name</label>
<input type="text" value="{{$afyauser->firstname.' '.$afyauser->secondName}}" class="form-control" readonly>
<input type="hidden" value="{{$id}}" name="afya_user_id">
<input type="hidden" value="{{$doc->id}}" name="doc_id">

</div>

    <div class="form-group ficha" id="depnd2">
    <label class="control-label" for="name">Name</label>
    <select name="dependant_id" class="form-control select2_demo_1"/>
    <option value=" ">Select dependant</option>
      @foreach($user as $use)
    <option value="{{$use->id}}">{{$use->firstName.' '.$use->secondName}}</option>
    @endforeach
    </select>
    <br><br>
    <a href="{{URL('private.addDependents',$id)}}" class="btn btn-success">Add Dependant</a>


    </div>


    <div class="form-group">
    <label class="control-label" for="name">Visit Type</label>
    <select name="visit" class="form-control select2_demo_1" required/>
    <option selected disabled value="">Select reason</option>
    <option value="normal">Normal Visit</option>
    <option value="Review">Review</option>
    <option value="Tests">Tests</option>
    <option value="Medical Report">Medical Report</option>
    </select>
    </div>

    {{-- <div class="form-group">
      <label class="control-label" for="name">Doctor</label>
       <select name="doc" class="form-control" required>
                 <option value="">Select Doctor</option>
                 @foreach($doctor as $doc)
               <option value="{{$doc->id}}">{{$doc->name}}</option>
                 @endforeach>
              </select>
      </div> --}}
<button type="submit" class="btn btn-primary  pull-right"> Submit</button>
<br><br><br>
    {!! Form::close() !!}


    </div>
    </div>
    </div>


        @elseif(!empty($facilitycode) && $setup != 'Partial')
        <div class="row">
            <div class="col-sm-5 col-sm-offset-1">
               <a href="{{URL('registrar.show',$id)}}" class="btn btn-primary btn-block">{{'Primary'}}</a>
            </div>
            <div class="col-sm-5">
                  <a href="{{URL('registrar.dependants',$id)}}" class="btn btn-success btn-block">{{'Dependant'}}</a>
            </div>
          </div>
          @endif
        </div>

<script>
function self1(){
document.getElementById('self2').style.display ='block';
document.getElementById('depnd2').style.display ='none';

}
function depnd1(){
document.getElementById('depnd2').style.display = 'block';
document.getElementById('self2').style.display ='none';

}
</script>
     @include('includes.default.footer')
@endsection
