<?php
$facility = DB::table('facility_doctor')
               ->join('facilities', 'facilities.FacilityCode', '=', 'facility_doctor.facilitycode')
               ->select('facility_doctor.facilitycode','facilities.set_up','facilities.FacilityName','facilities.Type')
               ->where('facility_doctor.user_id', Auth::user()->id)
               ->first();
?>


<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-md-6">
    <address>
      <br />
      <strong>FACILITY :</strong><br>
      <strong> Name :</strong>{{$facility->FacilityName}}<br>
      <strong> Type :</strong> {{$facility->Type}}<br>
    </address>
  </div>
  <div class="col-md-6 text-right">
    <address>
      <br /><br />
      <strong>DATE :</strong><br>
      {{date("l jS \of F Y ")}}
    </address>
  </div>
</div>
