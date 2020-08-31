@extends('layouts.app')
@section('title', 'Nurse Dashboard')


@section('content')
<div class="row">
<br><br>
<div class="col-lg-6">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
          <h5>Patient Details</h5>

      </div>
      <div class="ibox-content">
<?php $detail=DB::table('triage_infants')->where('id',$id)->first(); ?>


 {!! Form::open(array('url' => 'update_dep_preview','method'=>'POST')) !!}
    <div class="form-group">
    <input type="hidden" class="form-control" id="exampleInputEmail1S" aria-describedby="emailHelp" value="{{$id}}" name="id"  required>
    <input type="hidden" name="app_id" value="{{$detail->appointment_id}}">
    <div class="form-group">
    <label for="exampleInputEmail1">Weight</label>
    <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Weight" name="weight" value="{{$detail->weight}}"  required>
    </div>

     <div class="form-group">
    <label for="exampleInputEmail1">Head Head Measurement</label>
    <input type="name" class="form-control" placeholder="" name="cir" value="{{$detail->head_circum}}">
    </div>


     <div class="form-group">
    <label for="exampleInputEmail1">Head measurement</label>
    <input type="text" class="form-control" placeholder="Height in Metres" name="height" value="{{$detail->height}}"
     required>
    </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Temperature</label>
    <input type="number" class="form-control"  placeholder="Temperature" name="temperature"  value="{{$detail->temperature}}" required>
   </div>

    <div class="form-group">
    <label for="exampleInputPassword1">Systolic BP</label>
    <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Systolic BP" name="systolic"  value="{{$detail->systolic_bp}}" required>
    </div>
    <div class="form-group">
    <label for="exampleInputEmail1">Diastolic BP</label>
    <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Diastolic BP" name="diastolic"  value="{{$detail->diastolic_bp}}" required>
    </div>

    </div>
    </div>
  </div>
</div>






<div class="col-lg-6">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
          <h5>Patient Observations</h5>
      </div>
      <div class="ibox-content">






    <div class="form-group">
                     <label >Chief Complaint/Reason for visit:</label>
                      <textarea class="form-control" placeholer=""
                     name="chiefcompliant" required>{{$detail->chief_compliant}}
    </textarea>

                 </div>
     <div class="form-group">
                     <label >Observation:</label>
                      <textarea class="form-control" placeholer="" name="observation" required>{{$detail->observation}}
    </textarea

                 </div>
    <div class="form-group">
                     <label >Symptom:</label>
                     <textarea class="form-control" placeholer="" name="symptom" required>{{$detail->symptoms}}
    </textarea>

                 </div>



    <div class="form-group">
    <label for="exampleInputPassword1">Nurse Notes</label>
    <textarea class="form-control" placeholer="" name="nurse" required>{{$detail->nurse_notes}}
    </textarea>

    </div>



    <div class="form-group">
    <label for="exampleInputEmail1">Consulting Physician</label>
    <select class="form-control" name="doctor" value="" >
    <?php
  $facilitycode=DB::table('facility_nurse')->where('user_id', Auth::user()->id)->first();
  if($facilitycode){
  $facility=$facilitycode->facilitycode;
  }else{
    $facilitycode2=DB::table('facility_doctor')->where('user_id', Auth::user()->id)->first();
    $facility=$facilitycode2->facilitycode;
  }
$doctors = DB::table('users')
->join('facility_doctor','facility_doctor.user_id','=','users.id')
->select('facility_doctor.*','users.name as name')
->Where('facility_doctor.facilitycode',$facility)
// ->where('users.role','=','Doctor')
->get();?>
    @foreach($doctors as $doctor)
     <option value="{{$doctor->doctor_id}}">{{$doctor->name}}</option>
   @endforeach
  </select>

 </div>
    <button type="submit" class="btn btn-primary">Save</button>
     {!! Form::close() !!}


    </div>
    </div>
    </div>
    </div>

  @include('includes.default.footer')



@endsection
