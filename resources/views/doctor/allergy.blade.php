<div class="row">
<?php if ($pdetails->persontreated=='Self') { ?>
  <?php $allergy=DB::table('afya_users_allergy')
  ->Join('allergies_type', 'afya_users_allergy.allergies_type_id',  '=', 'allergies_type.id')
  ->where('afya_users_allergy.afya_user_id', '=',$afyauserId)->distinct()->get(['allergies_type.name']); ?>

<div class="col-sm-6  b-r ">
    <div class="ibox-content">
<label>Patient Allergy:</label>
@if ($allergy)
@foreach($allergy as $micrtest)
<input type="text" value="{{$micrtest->name}}" class="form-control" readonly="readonly">
@endforeach
@else
<input type="text" value="N/A" class="form-control" readonly="readonly">
@endif
</div>
</div>


  <?php $chronic=DB::table('appointments')
  ->Join('patient_diagnosis', 'appointments.id',  '=', 'patient_diagnosis.appointment_id')
  ->Join('icd10_option', 'patient_diagnosis.disease_id',  '=', 'icd10_option.id')
  ->where([['appointments.afya_user_id', '=',$afyauserId], ['patient_diagnosis.chronic', '=','Y'],])
  ->distinct()->get(['icd10_option.name']); ?>

<div class="col-sm-6">
    <div class="ibox-content">
<label>Patient Chronic Disease:</label>
@if($chronic)
@foreach($chronic as $micrtest)
<input type="text" value="{{$micrtest->name}}" class="form-control" readonly="readonly">
@endforeach
@else
<input type="text" value="N/A" class="form-control" readonly="readonly">
@endif
</div>
</div>


<?php } else { ?>
  <?php $allergy=DB::table('afya_users_allergy')
  ->Join('allergies_type', 'afya_users_allergy.allergies_type_id',  '=', 'allergies_type.id')
  ->where('afya_users_allergy.dependant_id', '=',$dependantId)->distinct()->get(['allergies_type.name']); ?>

<div class="col-sm-6 b-r">
    <div class="ibox-content">
<label>Patient Allergy:</label>
@if($allergy)
@foreach($allergy as $micrtest)
<input type="text" value="{{$micrtest->name}}" class="form-control" readonly="readonly">
@endforeach
@else
<input type="text" value="N/A" class="form-control" readonly="readonly">
@endif
</div>
</div>


<?php $Chronic=DB::table('appointments')
->Join('patient_diagnosis', 'appointments.id',  '=', 'patient_diagnosis.appointment_id')
->Join('icd10_option', 'patient_diagnosis.disease_id',  '=', 'icd10_option.id')
->where([ ['appointments.persontreated', '=',$dependantId],['patient_diagnosis.chronic', '=','Y'],])->distinct()->get(['icd10_option.name']); ?>

  <div class="col-sm-6">
    <div class="ibox-content">
<label>Patient Chronic Disease:</label>
@if($Chronic)
@foreach($Chronic as $micrtest)
<input type="text" value="{{$micrtest->name}}" class="form-control" readonly="readonly">
@endforeach
@else
<input type="text" value="N/A" class="form-control" readonly="readonly">
@endif
</div>
  </div>
<?php } ?>
</div>
