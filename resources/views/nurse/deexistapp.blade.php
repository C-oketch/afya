@extends('layouts.app')
@section('title', 'Dependant')
@section('content')
<div class="row">
<div class="col-lg-6">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
          <h5>Patient Details</h5>
          

      </div>
      <div class="ibox-content">
      

     
<?php 
      $triage=DB::table('triage_infants')->orderby('updated_at', 'desc')->where('dependant_id',$id)->first();?>
     
 {!! Form::open(array('url' => 'existingdetail','method'=>'POST')) !!}
    <div class="form-group">
    <input type="hidden" class="form-control" id="exampleInputEmail1S" aria-describedby="emailHelp" value="{{$id}}" name="id"  required>
    <input name="last_app_id" type="hidden" value="{{$app->id}}">
    <div class="form-group">
    <label for="exampleInputEmail1">Weight</label>
    <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$triage->weight or ''}}" placeholder="Weight" name="weight" readonly="">
    </div>
    
    <div class="form-group">
    <label for="exampleInputEmail1">Height</label>
    <input type="name" class="form-control" placeholder="Height in Metres" name="current_height" value="{{$triage->height or '' }}" 
     readonly="">
    </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Temperature</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Temperature" name="temperature" value="{{$triage->temperature or ''}}"  readonly="">
   </div>

    <div class="form-group">
    <label for="exampleInputPassword1">Systolic BP</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Systolic BP" name="systolic" value="{{$triage->systolic_bp or ''}}" readonly="">
    </div>
    <div class="form-group">
    <label for="exampleInputEmail1">Diastolic BP</label>
    <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Diastolic BP" value="{{$triage->diastolic_bp or ''}}" name="diastolic"  readonly="">
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
                     <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Diastolic BP" value="{{$triage->chief_compliant or ''}}" name="diastolic"  readonly="">
                 
    
                 </div>
     <div class="form-group">
                     <label >Observation:</label>
                   <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Diastolic BP" value="{{$triage->observation or ''}}" name="diastolic"  readonly="">
                    
                 </div>
    <div class="form-group">
                     <label >Symptom:</label>
                     <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Diastolic BP" value="{{$triage->symptoms or ''}}" name="diastolic"  readonly="">
                     

                 </div>
    
    

    <div class="form-group">
    <label for="exampleInputPassword1">Nurse Notes</label>


    <textarea class="form-control" placeholer="" name="nurse" readonly="">
    {{$triage->nurse_notes or ''}}
    </textarea>

    </div>
    <?php $db=DB::table('afya_users')->where('id',$id)->first(); $gender=$db->gender; ?>
    @if($gender==1)

    @else
    <div class="form-group">
    <label for="exampleInputPassword1">Pregnant?</label>
    <input type="radio" value="No"  name="pregnant"> No <input type="radio" value="Yes"  name="pregnant"> Yes
    </div>
   @endif


    <div class="form-group">
    <label for="exampleInputEmail1">Consulting Physician</label>
    <select class="form-control" name="doctor" >
    <?php 
     $facilitycode=DB::table('facility_nurse')->where('user_id', Auth::id())->first();

$doctors = DB::table('users')->
                    join('facility_doctor','facility_doctor.user_id','=','users.id')
                    ->select('facility_doctor.*','users.name as name')->Where('facility_doctor.facilitycode',$facilitycode->facilitycode)->where('users.role','=','Doctor')->get();?>
                  @foreach($doctors as $doctor)
                   <option value="{{$doctor->doctor_id}}">{{$doctor->name}}</option>
                 @endforeach
                </select>
                
<br>
    <button type="submit" class="btn btn-primary">Save</button>
     {!! Form::close() !!}
    </div>
</div>
    </div>
    </div>
    </div>
  

  @include('includes.default.footer')



@endsection
