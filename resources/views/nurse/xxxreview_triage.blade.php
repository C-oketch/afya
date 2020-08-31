@extends('layouts.nurse')
@section('title', 'Nurse Dashboard')
@section('content')
<?php
$patient= DB::table('afya_users')->where('id',$request->id)->first();
 ?>
@include('includes.nurse_inc.topnavbar')
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Review Patient Triage</h5>
                    </div>
<div class="ibox-content">
  <div class="row">
  {!! Form::open(array('route' => 'createdetail','method'=>'POST')) !!}
    <div class="col-lg-6">
        <h2>Patient Vitals</h2>
        <input type="hidden" class="form-control"  value="{{$request->id}}" name="id"  required>
        <input type="hidden" class="form-control" value="{{$request->appointment_id}}" name="appointment_id"  required>

      <div class="form-group">
      <label for="exampleInputEmail1">Weight (kg)</label>
      <input type="text" class="form-control"  value="{{$request->weight}}" name="weight"  required>
      </div>

      <div class="form-group">
      <label for="exampleInputEmail1">Height (cm)</label>
      <input type="text" class="form-control" value="{{$request->current_height}}" name="current_height" required>
      </div>
     <div class="form-group">
      <label for="exampleInputPassword1">Temperature °C</label>
      <input type="text" class="form-control" value="{{$request->temperature}}" name="temperature"  required>
     </div>

      <div class="form-group">
      <label for="exampleInputPassword1">Systolic BP</label>
      <input type="text" class="form-control"  value="{{$request->systolic}}" name="systolic"  required>
      </div>

      <div class="form-group">
      <label for="exampleInputEmail1">Diastolic BP</label>
      <input type="text" class="form-control"   value="{{$request->diastolic}}" name="diastolic"  required>
      </div>

      <div class="form-group">
      <label for="exampleInputEmail1">RBS mmol/l</label>
      <input type="name" class="form-control"  aria-describedby="emailHelp" value="{{$request->rbs}}" name="rbs">
      </div>

      <div class="form-group">
      <label for="exampleInputEmail1">HR b/min</label>
      <input type="name" class="form-control"  aria-describedby="emailHelp" value="{{$request->hr}}" name="hr">
      </div>

      <div class="form-group">
      <label for="exampleInputEmail1">RR breaths/min</label>
      <input type="name" class="form-control"  aria-describedby="emailHelp" value="{{$request->rr}}" name="rr">
      </div>


    </div>

    <div class="col-lg-6 ">
        <h2>Patient Observations</h2>

        @php
        $complaints = $request->chiefcomplaint;
        @endphp


        <div class="form-group">
        <label >Chief Complaint:</label><br />
        <select multiple="multiple" id="chief" name="chiefcomplaint[]" class="form-control chief" style="width:80%" required>
          @foreach($complaints as $complaint)
          <option selected="selected">{{$complaint}}</option>
          @endforeach
        </select>
        </div>

        @php
        $observations = $request->observation;
        @endphp

        <div class="form-group">
        <label >Observation:</label><br />
        <select multiple="multiple" id="observation" name="observation[]" class="form-control chief" style="width:80%">
          @foreach($observations as $observation)
          <option selected="selected">
            {{$observation}}
          </option>
          @endforeach
        </select>
        </div>

        @php
        $symptoms = $request->symptoms;
        @endphp

        <div class="form-group">
        <label >Symptom:</label><br />
        <select multiple="multiple" id="symptom" name="symptoms[]" class="form-control chief" style="width:80%">
          @foreach($symptoms as $symptom)
          <option selected="selected">
            {{$symptom}}
          </option>
          @endforeach
        </select>
        </div>

        <div class="form-group">
        <label for="exampleInputPassword1">Nurse Notes</label><br />
        <textarea class="form-control"  name="nurse" readonly required>{{$request->nurse}}</textarea>
        </div>

         <?php
         $db = DB::table('afya_users')
             ->where('id',$request->id)
             ->first();

         $gender = $db->gender;
          ?>
         @if($gender == 'Female')
        <div class="form-group">
       <label for="exampleInputPassword1">Pregnant?</label><br />
       <input type="text" class="form-control"   value="{{$request->pregnant}}" name="pregnant">
         </div>

         <div class="form-group">
         <label for="exampleInputEmail1">LMP </label>
         <input type="text" class="form-control"   value="{{$request->lmp}}" name="lmp">
         </div>

         @endif

<button type="submit" class="btn btn-primary">SUBMIT</button>
    </div>
    {!! Form::close() !!}
</div>
</div>
</div>
</div>
</div>

@endsection
@section('script-nurse')
<script type="text/javascript">
     $(document).ready(function(){

$(".chief").select2({
    placeholder: "Select chief compliant...",
    minimumInputLength: 2,
    ajax: {
        url: '/tag/chief',
        dataType: 'json',
        data: function (params) {
            return {
                q: $.trim(params.term)
            };
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    }
});


 });
</script>
@endsection
