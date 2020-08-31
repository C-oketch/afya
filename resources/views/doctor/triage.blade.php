<?php

$triage = DB::table('triage_details')->where('appointment_id',$app_id)
->first();
$family_planning = DB::table('family_planning')->where('afya_user_id',$afyauserId)
->first();
  ?>
<div class="wrapper wrapper-content">
 <div class="row">
   <div class="col-lg-12">
                       <div class="ibox float-e-margins">
                           <div class="ibox-title">
                               <h5>Today's Vitals </h5>
                               <div class="ibox-tools">
                               </div>
                           </div>
                           <div class="ibox-content">
                   <div class="row">
                   {!! Form::open(array('route' => 'trgpost','method'=>'POST')) !!}
                     <div class="col-lg-3 b-r">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">

                         <input type="hidden" class="form-control"  value="{{$afyauserId}}" name="id">
                         <input type="hidden" class="form-control" value="{{$app_id}}" name="appointment_id"  >
                         <input type="hidden" class="form-control" value="{{$gender}}" name="gender"  >

                       <div class="form-group">
                       <label for="exampleInputEmail1">Weight (kg)</label>
                       <input type="text" class="form-control"  value="@if($triage){{$triage->current_weight}} @endif" name="weight"  >
                       </div>

                       <div class="form-group">
                       <label for="exampleInputEmail1">Height (cm)</label>
                       <input type="text" class="form-control" value="@if($triage){{$triage->current_height}} @endif" name="current_height">
                       </div>
       </div>
        <div class="col-lg-3 br">
                      <div class="form-group">
                       <label for="exampleInputPassword1">Temperature °C</label>
                       <input type="text" class="form-control" value="@if($triage){{$triage->temperature}} @endif" name="temperature"  >
                      </div>

                       <div class="form-group">
                       <label for="exampleInputPassword1">Systolic BP</label>
                       <input type="text" class="form-control"  value="@if($triage){{$triage->systolic_bp}} @endif" name="systolic" >
                   </div>
</div>
 <div class="col-lg-3 br">
                       <div class="form-group">
                       <label for="exampleInputEmail1">Diastolic BP</label>
                       <input type="text" class="form-control"   value="@if($triage){{$triage->diastolic_bp}} @endif" name="diastolic">
                       </div>

                       <div class="form-group">
                       <label for="exampleInputEmail1">RBS mmol/l</label>
                       <input type="name" class="form-control"   value="@if($triage){{$triage->rbs}} @endif" name="rbs">
                       </div>




                     </div>

                     <div class="col-lg-3">

                       <div class="form-group">
                       <label for="exampleInputEmail1">HR b/min</label>
                       <input type="name" class="form-control"  value="@if($triage){{$triage->hr}} @endif" name="hr">
                       </div>

                       <div class="form-group">
                       <label for="exampleInputEmail1">SpO<small>2</small></label>
                       <input type="name" class="form-control"   value="@if($triage){{$triage->rr}} @endif" name="rr">
                       </div>



 </div>

<div class="col-md-3">
<?php
$today = date('Y-m-d');
?>
@if($gender == 'Female')
<div class="form-group">
<label for="exampleInputPassword1">Pregnant?</label><br />
<input type="radio" value="No"  name="pregnant"  @if($triage) <?php  echo ($triage->pregnant=='No')?'checked':'' ?> @endif > No
<input type="radio" value="Yes"  name="pregnant" @if($triage) <?php echo ($triage->pregnant=='Yes')?'checked':'' ?> @endif > Yes

<!-- <input type="text" class="form-control"   value="@if($triage){{$triage->pregnant}} @endif" name="pregnant"> -->
</div>
</div>
<div class="col-md-3">
<div class="form-group" id="data_1">
<label for="exampleInputPassword1">LMP</label>
<div class="input-group date">
<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
<input type="text" class="form-control" value="@if($triage){{$triage->lmp}}  @endif" name="lmp"  />
</div>
</div>
</div>


<!-- <div class="col-md-3">
<div class="form-group">
<label>LMP</label>
<input type="text" class="form-control" value="@if($triage){{$triage->lmp}}  @endif" name="lmp"  />
</div>
</div> -->


<div class="col-md-6">
  <div class="form-group">
  <label for="exampleInputEmail1">Parity</label>
  <input type="text" class="form-control"   value="@if($family_planning){{$family_planning->parity}} @endif" name="parity">
  </div>
</div>
  <div class="col-md-12">
    <div class="form-group">
    <label class="col-md-4">Family Planning Method</label>
    <div class="col-md-6">
     <textarea rows="6" name="famplan" cols="80">@if($family_planning){{$family_planning->family_planning}} @endif</textarea>
    </div>
  </div>
</div>

@endif
<div class="col-md-12">
<button type="submit" class="btn btn-primary">@if($triage)UPDATE @else SUBMIT @endif</button>
</div>
<br><br>
                     {!! Form::close() !!}
                   </div>
 </div>
</div>
</div>

</div>
</div>
