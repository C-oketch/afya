@extends('layouts.show')
@section('content')
<!--tabs3-->
<?php
$doc = (new \App\Http\Controllers\DoctorController);
$Docdatas = $doc->DocDetails();
foreach($Docdatas as $Docdata){


$Did = $Docdata->id;
$Name = $Docdata->name;
$Address = $Docdata->address;
$RegNo = $Docdata->regno;
$RegDate = $Docdata->regdate;
$Speciality = $Docdata->speciality;
$Sub_Speciality = $Docdata->subspeciality;
$Duser = $Docdata->user_id;

}

        foreach ($patientD as $pdetails) {

           $stat= $pdetails->status;
           $afyauserId= $pdetails->afya_user_id;
            $dependantId= $pdetails->persontreated;
            $app_id= $pdetails->id;
            $doc_id= $pdetails->doc_id;
            $fac_id= $pdetails->facility_id;
            $fac_setup= $pdetails->set_up;
            $dependantAge = $pdetails->depdob;
            $AfyaUserAge = $pdetails->dob;
            $condition = $pdetails->condition;

        $now = time(); // or your date as well
        $your_date = strtotime($dependantAge);
        $datediff = $now - $your_date;
        $dependantdays= floor($datediff / (60 * 60 * 24));


        if ($dependantId =='Self') {
              $dob=$AfyaUserAge;
              $gender=$pdetails->gender;
            $firstName = $pdetails->firstname;
            $secondName = $pdetails->secondName;
            $name =$firstName." ".$secondName;
        }

        else {
             $dob=$dependantAge;
             $gender=$pdetails->depgender;
             $firstName = $pdetails->dep1name;
             $secondName = $pdetails->dep2name;
             $name =$firstName." ".$secondName;
        }
        $interval = date_diff(date_create(), date_create($dob));
        $age= $interval->format(" %Y Year, %M Months, %d Days Old");
        $appStatue=$stat;
        if ($appStatue == 2) {
        $appStatue ='ACTIVE';
        } elseif ($stat == 3) {
        $appStatue='Discharged Outpatient';
        } elseif ($stat == 4) {
        $appStatue='Admitted';
        } elseif ($stat == 5) {
        $appStatue='Refered';
        }
        elseif ($stat == 6) {
        $appStatue='Discharged Intpatient';
        }

        }
        ?>
        
        @include('includes.doc_inc.topnavbar_v2')
        <!--tabs Menus-->
          @include('includes.doc_inc.headmenu')
<!--tabs Menus-->
<div class="row wrapper border-bottom">
       <div class="ibox float-e-margins">
         <div class="col-lg-12">
           <div class="tabs-container">

<div class="ibox-content">
<div class="row">

    <div class="col-sm-4 b-r"><h3 class="m-t-none m-b">Discharge Condition</h3>


      <div class="form-group">
          <label for="tag_list" class="">Discharge Condition:</label>
               <select id="dcond" class="form-control" name="disconditions"  style="width: 100%" >
                 <option value=''>Choose one</option>
                 <option value="1">Discharge Referral</option>
                 <option value="2">Discharge Home</option>
                 <option value="3">Discharge Home With Follow up </option>
                 <option value="4">Dead</option>
                 </select>
      </div>


    </div>

    <div class="col-sm-8"><h4>Action</h4>

      <div id="hidden_div1" style="display: none;">
        <div id="transfer" class="panel-body">
          {{ Form::open(array('route' => array('discharging'),'method'=>'POST')) }}

                <div class="form-group ">
                    <label for="presc" class="col-md-6">Facility:</label>
                    <select id="facility" name="facility_to" class="form-control facility1" style="width: 100%"></select>
                </div>

               {{ Form::hidden('facility_from','facility id', array('class' => 'form-control')) }}
               {{ Form::hidden('appointment_status',5, array('class' => 'form-control')) }}
               {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
               {{ Form::hidden('doc_id',$doc_id, array('class' => 'form-control')) }}
               {{ Form::hidden('target','Transfer', array('class' => 'form-control')) }}
             {{ Form::hidden('discondition','Discharg Transfer', array('class' => 'form-control')) }}


      <div class="form-group ">
      <label for="role" class="control-label">Doctor note</label>
      {{ Form::textarea('doc_note', null, array('placeholder' => 'note..','class' => 'form-control col-lg-8')) }}
      </div>
      <div class="form-group  col-md-offset-1">
      <button type="submit" class="btn btn-primary">Submit</button>  </td>
      </div>
      {{ Form::close() }}

      </div><!--panel body-->
      </div>
<!--Discharge home -->
      <div id="hidden_div2" style="display: none;">
  {{ Form::open(array('route' => array('discharging'),'method'=>'POST')) }}


       {{ Form::hidden('appointment_status',3, array('class' => 'form-control')) }}
       {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
       {{ Form::hidden('doc_id',$doc_id, array('class' => 'form-control')) }}
       {{ Form::hidden('target','Discharge', array('class' => 'form-control')) }}
     {{ Form::hidden('discondition','Discharg Home', array('class' => 'form-control')) }}


      <div class="form-group ">
      <label for="role" class="control-label">Doctor note</label>
      {{ Form::textarea('doc_note', null, array('placeholder' => 'note..','class' => 'form-control col-lg-8')) }}
      </div>
      <div class="form-group  col-md-offset-1">
      <button type="submit" class="btn btn-primary">Submit</button>  </td>
      </div>
      {{ Form::close() }}
  </div>
<!--Discharge home with follow up-->
  <div id="hidden_div3" style="display: none;">
    {{ Form::open(array('route' => array('discharging'),'method'=>'POST')) }}
    <div class="form-group" id="data_1">
        <label class="font-normal">Next Doctor Visit</label>
        <div class="input-group date">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            <input type="text" class="form-control" name="next_appointment" value="">
        </div>
    </div>



   {{ Form::hidden('appointment_status',1, array('class' => 'form-control')) }}
   {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
   {{ Form::hidden('doc_id',$doc_id, array('class' => 'form-control')) }}
   {{ Form::hidden('target','Discharge', array('class' => 'form-control')) }}
   {{ Form::hidden('discondition','Discharg Home Follow Up', array('class' => 'form-control')) }}
  {{ Form::hidden('docr',$Duser, array('class' => 'form-control')) }}
  {{ Form::hidden('afyaUser',$afyauserId, array('class' => 'form-control')) }}
  {{ Form::hidden('dependt',$dependantId, array('class' => 'form-control')) }}
  {{ Form::hidden('facility_id',$fac_id, array('class' => 'form-control')) }}


  <div class="form-group ">
  <label for="role" class="control-label">Doctor note</label>
  {{ Form::textarea('doc_note', null, array('placeholder' => 'note..','class' => 'form-control col-lg-8')) }}
  </div>
  <div class="form-group  col-md-offset-1">
  <button type="submit" class="btn btn-primary">Submit</button>  </td>
  </div>
  {{ Form::close() }}
</div>
<!--Discharge Death-->
<div id="hidden_div4" style="display: none;">
  {{ Form::open(array('route' => array('discharging'),'method'=>'POST')) }}
  <div class="form-group" id="data_1">
      <label class="font-normal">Date of Death</label>
      <div class="input-group date">
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
          <input type="text" class="form-control" name="date_of_death">
      </div>
  </div>
  <div class="form-group">
    <label class="font-normal">Time of Death</label>
  <div class="input-group clockpicker" data-autoclose="true">
      <input type="text" class="form-control"name="time_of_death" placeholder="09:30" >
      <span class="input-group-addon">
          <span class="fa fa-clock-o"></span>
      </span>
    </div>
  </div>


  {{ Form::hidden('appointment_status',0, array('class' => 'form-control')) }}
  {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
  {{ Form::hidden('doc_id',$doc_id, array('class' => 'form-control')) }}
  {{ Form::hidden('target','Discharge', array('class' => 'form-control')) }}
  {{ Form::hidden('discondition','Discharg Death', array('class' => 'form-control')) }}

<div class="form-group ">
<label for="role" class="control-label">Doctor note</label>
{{ Form::textarea('doc_note', null, array('placeholder' => 'note..','class' => 'form-control col-lg-8')) }}
</div>
<div class="form-group  col-md-offset-1">
<button type="submit" class="btn btn-primary">Submit</button>  </td>
</div>
{{ Form::close() }}
</div>


      </div>
  </div>
</div>


        </div>
      </div><!-- col md 12" -->
   </div><!-- emargis" -->
</div>
@endsection
