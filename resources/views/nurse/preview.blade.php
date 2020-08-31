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
<?php $detail=DB::table('triage_details')->where('id',$id)->first(); ?>


 {!! Form::open(array('url' => 'update_preview','method'=>'POST')) !!}
    <div class="form-group">
    <input type="hidden" class="form-control" id="exampleInputEmail1S" aria-describedby="emailHelp" value="{{$id}}" name="id"  required>
    <input type="hidden" name="app_id" value="{{$detail->appointment_id}}">
    <div class="form-group">
    <label for="exampleInputEmail1">Weight</label>
    <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Weight" name="weight" value="{{$detail->current_weight}}"  required>
    </div>

    <div class="form-group">
    <label for="exampleInputEmail1">Height</label>
    <input type="text" class="form-control"placeholder="Height in Metres" name="current_height" value="{{$detail->current_height}}"
     required>
    </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Temperature</label>
    <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Temperature" name="temperature"  value="{{$detail->temperature}}" required>
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
    <?php $pregnt=$detail->pregnant; ?>
    @if(!empty($pregnt))
    <div class="form-group">
    <label for="exampleInputPassword1">Pregnant?</label>
    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Temperature" name="pregnant"  value="{{$detail->pregnant}}" required>
    </div>


    <div class="form-group" id="data_1">
                 <label for="exampleInputPassword1">LMP</label>
                 <div class="input-group date">
                     <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                     <input type="text" class="form-control" name="lmp" value="{{$detail->lmp}}">
                 </div>
                 </div>
   @endif


    <div class="form-group">
    <label for="exampleInputEmail1">Consulting Physician</label>
    <select class="form-control" name="doctor" required>
      <?php
      $doc = DB::table('appointments')
            ->join('triage_details', 'triage_details.appointment_id', '=', 'appointments.id')
            ->join('doctors', 'doctors.id', '=', 'appointments.doc_id')
            ->select('doctors.name','doctors.id')
            ->where('triage_details.id', '=', $id)
            ->first();
       ?>
     <option selected value="{{$doc->id}}">{{$doc->name}}</option>
    <?php
     $facilitycode=DB::table('facility_nurse')->where('user_id', Auth::id())->first();

$doctors = DB::table('users')->
                    join('facility_doctor','facility_doctor.user_id','=','users.id')
                    ->select('facility_doctor.*','users.name as name')->Where('facility_doctor.facilitycode',$facilitycode->facilitycode)->where('users.role','=','Doctor')->get();?>
                  @foreach($doctors as $doctor)
                   <option value="{{$doctor->doctor_id}}">{{$doctor->name}}</option>
                 @endforeach
                </select>

 </div>
    <button type="submit" class="btn btn-primary">SUBMIT</button>
     {!! Form::close() !!}


    </div>
    </div>
    </div>
    </div>

  @include('includes.default.footer')



@endsection
