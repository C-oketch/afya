@extends('layouts.nurse_layout')
@section('title', 'Nurse Dashboard')


@section('content')
<?php   $pat=$patient->id;  ?>
@section('leftmenu')
@include('includes.nurse_inc.leftmenu2')
@endsection
@include('includes.nurse_inc.topnavbar')
<div class="row">
<br><br>
<div class="col-lg-6">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
          <h5>Patient Details</h5>
      </div>
      <div class="ibox-content">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

 {!! Form::open(array('route' => 'reviewdetail','method'=>'POST')) !!}
    <div class="form-group">
    <input type="hidden" class="form-control" value="{{$patient->id}}" name="id"  required>
        <input type="hidden" class="form-control" value="{{$patient->appid}}" name="appointment_id"  required>
    <div class="form-group">
    <label for="exampleInputEmail1">Weight (kg)</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="80" name="weight"  required>
    </div>

    <div class="form-group">
    <label for="exampleInputEmail1">Height (cm)</label>
    <input type="text" class="form-control" placeholder="200" name="current_height"
     required>
    </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Temperature °C</label>
    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="37.2" name="temperature"  required>
   </div>

    <div class="form-group">
    <label for="exampleInputPassword1">Systolic BP</label>
    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="110" name="systolic"  required>
    </div>

    <div class="form-group">
    <label for="exampleInputEmail1">Diastolic BP</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="60 - 110" name="diastolic"  required>
    </div>

    <div class="form-group">
    <label for="exampleInputEmail1">RBS mmol/l</label>
    <input type="name" class="form-control"  aria-describedby="emailHelp" placeholder="RBS mmol/l" name="rbs">
    </div>

    <div class="form-group">
    <label for="exampleInputEmail1">HR b/min</label>
    <input type="name" class="form-control"  aria-describedby="emailHelp" placeholder="HR b/min" name="hr">
    </div>

    <div class="form-group">
    <label for="exampleInputEmail1">RR breaths/min</label>
    <input type="name" class="form-control"  aria-describedby="emailHelp" placeholder="RR breaths/min" name="rr">
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
<label >Chief Complaint:</label><br />
<select multiple="multiple" id="chief" name="chiefcomplaint[]" class="form-control chief" style="width:80%" required></select>
</div>


<div class="form-group">
<label >Observation:</label><br />
<select multiple="multiple" id="observation" name="observation[]" class="form-control chief" style="width:80%"></select>
</div>

<div class="form-group">
<label >Symptom:</label><br />
<select multiple="multiple" id="symptom" name="symptoms[]" class="form-control chief" style="width:80%"></select>
</div>

<div class="form-group">
<label for="exampleInputPassword1">Nurse Notes</label><br />
<textarea class="form-control" placeholer="" name="nurse" required></textarea>
</div>
    <?php
    $db = DB::table('afya_users')
        ->where('id',$patient->id)
        ->first();

    $gender=$db->gender;
     ?>
    @if($gender=='Female')
   <div class="form-group">
  <label for="exampleInputPassword1">Pregnant?</label><br />
  <input type="radio" value="No"  name="pregnant"> No <input type="radio" value="Yes"  name="pregnant"> Yes
    </div>

    <div class="form-group" id="data_1">
<label for="exampleInputPassword1">LMP</label><br />
  <div class="input-group date">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                     <input type="text" class="form-control" name="lmp" value="">
                 </div>
                 </div>
   @endif

<?php
 $doctors = DB::table('doctors')->select('name')->where('id',$patient->doc_id)->first();
?>

 <div class="form-group">
 <label for="exampleInputEmail1">Consulting</label>
 <input type="text" class="form-control" value="{{$doctors->name}}"   readonly>
 </div>
    <button type="submit" class="btn btn-primary">SUBMIT</button>
     {!! Form::close() !!}


    </div>
    </div>

    </div>
    </div>

  @include('includes.default.footer')



  @endsection
  @section('script')
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
