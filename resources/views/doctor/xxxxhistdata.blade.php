@extends('layouts.doctor_layout')
@section('title', 'Details')
@section('content')
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
$set_up = $Docdata->set_up;
}
$afyauserId =$patient->id;
$app_id=$patient->appid;
?>
@include('includes.doc_inc.topnavbar_v2')

<div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                  <h2>Self Reported Details</h2>
              </div>
              <div class="col-lg-2">
                <br>
                <a href="{{ url('doctor.show',$app_id) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </a>
              </div>
  </div>

          <div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="ibox float-e-margins">
            <div class="tab" role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab">Smoking & Alcohol</a></li>
                    <li role="presentation" class=""><a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab">Medical History</a></li>
                    <li role="presentation" class=""><a href="#Section3" aria-controls="messages" role="tab" data-toggle="tab">Surgical Procedures & Chronic</a></li>
                    <li role="presentation" class=""><a href="#Section4" aria-controls="profile" role="tab" data-toggle="tab">Medications & Allergies</a></li>
                    <li role="presentation" class=""><a href="#Section5" aria-controls="messages" role="tab" data-toggle="tab">Vaccinations</a></li>
                    <li role="presentation" class=""><a href="#Section6" aria-controls="messages" role="tab" data-toggle="tab">Abnormalities</a></li>

                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabs">
                    <div role="tabpanel" class="tab-pane fade in active" id="Section1">


{!! Form::open(array('url' => 'doctor.smoking_store','method'=>'POST','class'=>'form-horizontal')) !!}
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" value="{{$patient->id}}" name="afya_user_id">
    <input type="hidden" value="{{$patient->appid}}" name="appointment_id">

  <div class="col-lg-6 b-r"><h3>Smoking Details</h3>
    @if($smoking)<input type="hidden" value="{{$smoking->id}}" name="smoking_id">@endif

      <div class="form-group smoker">
        <label class="col-sm-6 control-label">Are you a smoker?</label>

        <div class="col-sm-6">

          <label class="checkbox-inline"> <input type="radio" class="smoker"  name="smoker" value="YES" @if($smoking)     @if($smoking->smoker=='YES') checked @endif  @endif> Yes</label>
          <label class="checkbox-inline"> <input type="radio" class="smoker"  name="smoker" value="NO"   @if($smoking)       @if($smoking->smoker=='NO') checked @endif @endif> No</label>
        </div>
      </div>

      <div class="form-group cigarretes">
        <label class="col-sm-6 control-label">How many cigarretes per day?</label>

        <div class="col-sm-6">
          <input type="text" name="cigarretes_per_day" value="@if($smoking){{$smoking->cigarretes_per_day}}@endif" class="form-control" >

        </div>
      </div>

      <div class="form-group eversmoked">
        <label class="col-sm-6 control-label">Have you ever smoked?</label>

        <div class="col-sm-6">
          <label class="checkbox-inline "> <input type="radio" class="eversmoked" name="ever_smoked" value="YES" @if($smoking) @if($smoking->ever_smoked=='YES') checked @endif @endif> Yes</label>
          <label class="checkbox-inline "> <input type="radio" class="eversmoked" name="ever_smoked" value="NO"  @if($smoking) @if($smoking->ever_smoked=='NO') checked @endif  @endif> No</label>
        </div>
      </div>

      <div class="form-group stopdate ficha">
        <label class="col-sm-6 control-label">When did you stop?</label>

        <div class="col-sm-6">
          <input type="text" name="stop_date" value="@if($smoking){{$smoking->stop_date}}@endif" class="form-control monthly" >

        </div>
      </div>

      <div class="form-group period">

        <label class="col-sm-6 control-label">How long did you smoke/have you smoked(years)?</label>

        <div class="col-sm-6">
          <select name="period_smoked" class="form-control">
          @if($smoking)  <option value="{{$smoking->period_smoked}}" >{{$smoking->period_smoked}}</option>@endif
            <option value="1">0-1</option>
            @for($i=2;$i< 61;$i++)
            <option value="{{$i}}">{{$i}}</option>
            @endfor
          </select>
        </div>
      </div>



</div>
<div class="col-lg-6"><h3>Alcohol/Drug Details</h3>

  @if($alcohol)  <input type="hidden" value="{{$alcohol->id}}" name="alcohol_id">@endif
                                  <div class="form-group drink">
                                    <label class="col-sm-6 control-label">Do you drink Alcohol?</label>

                                    <div class="col-sm-6">
                                      <label class="checkbox-inline "> <input type="radio" class="drink" name="drink" value="YES" @if($alcohol) @if($alcohol->drink=='YES') checked @endif @endif> Yes</label>
                                      <label class="checkbox-inline "> <input type="radio" class="drink" name="drink" value="NO"  @if($alcohol) @if($alcohol->drink=='NO') checked @endif  @endif> No</label>
                                    </div>
                                  </div>

                                  <div class="form-group frequency">
                                    <label class="col-sm-6 control-label">How how frequent?</label>

                                    <div class="col-sm-6">
                                      <select name="drinking_frequency" class="form-control">
                                        @if($alcohol)<option value="{{$alcohol->drinking_frequency}}">{{$alcohol->drinking_frequency}}</option> @endif
                                        <option value="daily">daily</option>
                                        <option value="every other day">every other day</option>
                                        <option value="weekly">weekly</option>
                                        <option value="Once a month">Once a month</option>

                                      </select>

                                    </div>
                                  </div>

                                  <div class="form-group drugs">
                                    <label class="col-sm-6 control-label">Do you or have you ever used recreational drugs?</label>

                                    <div class="col-sm-6">
                                      <label class="checkbox-inline "> <input type="radio" class="drugs" name="used_recreational_drugs" value="YES" @if($alcohol) @if($alcohol->used_recreational_drugs=='YES') checked @endif @endif> Yes</label>
                                      <label class="checkbox-inline "> <input type="radio" class="drugs" name="used_recreational_drugs" value="NO"  @if($alcohol) @if($alcohol->used_recreational_drugs=='NO') checked @endif  @endif> No</label>
                                    </div>
                                  </div>

                                  <div class="form-group drug_type">
                                    <label class="col-sm-6 control-label">If yes state type?</label>

                                    <div class="col-sm-6">
                                      <input type="text" name="drug_type"  value="@if($alcohol){{$alcohol->drug_type}}@endif" class="form-control" >

                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="col-sm-6 control-label">Do you drink liquids with caffeine - coffee, tea?</label>

                                    <div class="col-sm-6">
                                      <label class="checkbox-inline "> <input type="radio" name="caffeine_liquids" value="YES" @if($alcohol) @if($alcohol->caffeine_liquids=='YES') checked @endif @endif > Yes</label>
                                      <label class="checkbox-inline "> <input type="radio" name="caffeine_liquids" value="NO"  @if($alcohol) @if($alcohol->caffeine_liquids=='NO') checked @endif @endif > No</label>
                                    </div>
                                  </div>
                                  <br><br>
</div>

<div class="pull-right">
<button class="btn btn-primary"  type="submit"><strong>Submit</strong></button>
{!! Form::close() !!}
  </div>
</div>

  <div role="tabpanel" class="tab-pane fad" id="Section2">
    <h3>Self Reported Medical History</h3>
    <div class="col-sm-6 b-r">
      {!! Form::open(array('url' => 'doctor.medical','method'=>'POST')) !!}
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" value="{{$patient->id}}" name="afya_user_id">
          <input type="hidden" value="{{$patient->appid}}" name="appointment_id">
      @if($medical)  <input type="hidden" value="{{$medical->id}}" name="medical_id">@endif
<div class="form-group">
        <label class="col-sm-6 control-label">Hypertension?</label>

        <div class="col-sm-6">
          <label class="checkbox-inline "> <input type="radio" name="hypertension" value="YES" @if($medical)@if($medical->hypertension=='YES') checked @endif @endif > Yes</label>
          <label class="checkbox-inline "> <input type="radio" name="hypertension" value="NO" @if($medical)@if($medical->hypertension=='NO') checked @endif @endif > No</label>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-6 control-label">Diabetes?</label>

        <div class="col-sm-6">
          <label class="checkbox-inline "> <input type="radio" name="diabetes" value="YES" @if($medical)@if($medical->diabetes=='YES') checked @endif @endif > Yes</label>
          <label class="checkbox-inline "> <input type="radio" name="diabetes" value="NO" @if($medical)@if($medical->diabetes=='NO') checked @endif @endif > No</label>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-6 control-label">Heart Attack?</label>

        <div class="col-sm-6">
          <label class="checkbox-inline "> <input type="radio" name="heart_attack" value="YES" @if($medical)@if($medical->heart_attack=='YES') checked @endif @endif > Yes</label>
          <label class="checkbox-inline "> <input type="radio" name="heart_attack" value="NO" @if($medical)@if($medical->heart_attack=='NO') checked @endif @endif > No</label>
        </div>
      </div>


      <div class="form-group">
        <label class="col-sm-6 control-label">Stroke?</label>

        <div class="col-sm-6">
          <label class="checkbox-inline "> <input type="radio" name="stroke" value="YES" @if($medical)@if($medical->stroke=='YES') checked @endif @endif > Yes</label>
          <label class="checkbox-inline "> <input type="radio" name="stroke" value="NO" @if($medical)@if($medical->stroke=='NO') checked @endif @endif > No</label>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">Skin Problems?</label>

        <div class="col-sm-6">
          <label class="checkbox-inline "> <input type="radio" name="skin_problems" value="YES" @if($medical)@if($medical->skin_problems=='YES') checked @endif @endif > Yes</label>
          <label class="checkbox-inline "> <input type="radio" name="skin_problems" value="NO" @if($medical)@if($medical->skin_problems=='NO') checked @endif @endif > No</label>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-6 control-label">Liver Disease?</label>

        <div class="col-sm-6">
          <label class="checkbox-inline "> <input type="radio" name="liver_disease" value="YES" @if($medical)@if($medical->liver_disease=='YES') checked @endif @endif > Yes</label>
          <label class="checkbox-inline "> <input type="radio" name="liver_disease" value="NO" @if($medical)@if($medical->liver_disease=='NO') checked @endif @endif > No</label>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-6 control-label">Lung Disease?</label>

        <div class="col-sm-6">
          <label class="checkbox-inline "> <input type="radio" name="lung_disease" value="YES" @if($medical)@if($medical->lung_disease=='YES') checked @endif @endif > Yes</label>
          <label class="checkbox-inline "> <input type="radio" name="lung_disease" value="NO" @if($medical)@if($medical->lung_disease=='NO') checked @endif @endif > No</label>
        </div>
      </div>
</div>
<div class="col-sm-6 b-r">
  <br>
      <div class="form-group">
        <label class="col-sm-6 control-label">Bowel Disease?</label>

        <div class="col-sm-6">
          <label class="checkbox-inline "> <input type="radio" name="bowel_disease" value="YES" @if($medical)@if($medical->bowel_disease=='YES') checked @endif @endif > Yes</label>
          <label class="checkbox-inline "> <input type="radio" name="bowel_disease" value="NO" @if($medical)@if($medical->bowel_disease=='NO') checked @endif @endif > No</label>
        </div>
      </div>


      <div class="form-group">
        <label class="col-sm-6 control-label">Eye Disease?</label>

        <div class="col-sm-6">
          <label class="checkbox-inline "> <input type="radio" name="eye_disease" value="YES" @if($medical)@if($medical->eye_disease=='YES') checked @endif @endif > Yes</label>
          <label class="checkbox-inline "> <input type="radio" name="eye_disease" value="NO" @if($medical)@if($medical->eye_disease=='NO') checked @endif @endif > No</label>
        </div>
      </div>



      <div class="form-group">
        <label class="col-sm-6 control-label">Pyschological problems?</label>

        <div class="col-sm-6">
          <label class="checkbox-inline "> <input type="radio" name="pyschological_problems" value="YES" @if($medical)@if($medical->pyschological_problems=='YES') checked @endif @endif > Yes</label>
          <label class="checkbox-inline "> <input type="radio" name="pyschological_problems" value="NO" @if($medical)@if($medical->pyschological_problems=='NO') checked @endif @endif > No</label>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">Arthritis/joint disease?</label>

        <div class="col-sm-6">
          <label class="checkbox-inline "> <input type="radio" name="arthritis_joint_disease" value="YES" @if($medical)@if($medical->arthritis_joint_disease=='YES') checked @endif @endif > Yes</label>
          <label class="checkbox-inline "> <input type="radio" name="arthritis_joint_disease" value="NO" @if($medical)@if($medical->arthritis_joint_disease=='NO') checked @endif @endif > No</label>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-6 control-label">Thyroid Disease?</label>

        <div class="col-sm-6">
          <label class="checkbox-inline "> <input type="radio" name="thyroid_disease" value="YES" @if($medical)@if($medical->thyroid_disease=='YES') checked @endif @endif > Yes</label>
          <label class="checkbox-inline "> <input type="radio" name="thyroid_disease" value="NO" @if($medical)@if($medical->thyroid_disease=='NO') checked @endif @endif > No</label>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">Gyneocological Disease?</label>

        <div class="col-sm-6">
          <label class="checkbox-inline "> <input type="radio" name="gyneocological_disease" value="YES" @if($medical)@if($medical->gyneocological_disease=='YES') checked @endif @endif > Yes</label>
          <label class="checkbox-inline "> <input type="radio" name="gyneocological_disease" value="NO" @if($medical)@if($medical->gyneocological_disease=='NO') checked @endif @endif > No</label>
        </div>
      </div>


         </div>
   <div class="pull-right">
   <button class="btn btn-primary"  type="submit"><strong>Submit</strong></button>
   {!! Form::close() !!}
     </div>
</div>



  <div role="tabpanel" class="tab-pane fade" id="Section3">

      <div class="col-sm-6 b-r"><h3>Surgical Procedures</h3>
        {!! Form::open(array('url' => 'doctor.surgical','method'=>'POST')) !!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" value="{{$patient->id}}" name="afya_user_id">
            <input type="hidden" value="{{$patient->appid}}" name="appointment_id">

<div class="form-group col-sm-6">
<label class="control-label" for="name">Procedure Name</label>
<input type="text" name="name_of_surgery1" class="form-control" placeholder="Name of Procedure">
</div>

<div class="form-group col-sm-6 data_1">
<label class="control-label" for="name">Procedure Date</label>
<div class="input-group date">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
    <input type="text" class="form-control" name="surgery_date1" value="{{$today = date('Y-m-d')}}">
</div>
</div>

<div class="form-group col-sm-6">
<label class="control-label" for="name">Procedure Name</label>
<input type="text" name="name_of_surgery2" class="form-control" placeholder="Name of Procedure">
</div>

<div class="form-group col-sm-6 data_1">
<label class="control-label" for="name">Procedure Date</label>
<div class="input-group date">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
    <input type="text" class="form-control" name="surgery_date2" value="{{$today = date('Y-m-d')}}">
</div>
</div>
</div>
<div class="col-sm-6">  <h3>Chronic Diseases</h3>
  <div class="form-group col-sm-6">
  <label class="control-label" for="name">Chronic</label>
  <input type="text" name="chronic1" class="form-control" placeholder="Name of disease">
  </div>

  <div class="form-group col-sm-6">
  <label class="control-label" for="name">Status</label>
  <input type="text" name="status1" class="form-control daily"  placeholder="status">
  </div>
  <div class="form-group col-sm-6">
  <label class="control-label" for="name">Chronic</label>
  <input type="text" name="chronic2" class="form-control" placeholder="Name of disease">
  </div>

  <div class="form-group col-sm-6">
  <label class="control-label" for="name">Status</label>
  <input type="text" name="status2" class="form-control daily"  placeholder="status">
  </div>

</div>

<div class="pull-right">
<button class="btn btn-primary"  type="submit"><strong>Submit</strong></button>
{!! Form::close() !!}
  </div>
</div>
                    <div role="tabpanel" class="tab-pane fade" id="Section4">
                        <h3>Medicine History</h3>
                        <div class="col-lg-6 b-r">
                          {!! Form::open(array('url' => 'doctor.drug','method'=>'POST','class'=>'form-horizontal')) !!}
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="hidden" value="{{$patient->id}}" name="afya_user_id">
                              <input type="hidden" value="{{$patient->appid}}" name="appointment_id">


                              <div class="form-group col-md-11">
                              <label>Drug Allergy</label><br>
                              <select multiple="multiple" class="form-control allergies" name="allergies[]" style="width:100%">
                              <?php $druglists = DB::table('allergies_type')->get();?>
                              @foreach($druglists as $druglist)
                               <option value="{{$druglist->id}}">{{$druglist->name}}</option>
                              @endforeach
                              </select>
                              </div>



  <div class="form-group col-md-12">
  <label class="control-label" for="name">Drug Name</label>
  <div>
    <input type="text" name="drug_id1" class="form-control daily">
  </div>
  </div>
  <div class="form-group col-md-6">
   <label class="control-label" for="name">Dosage</label>
   <input type="text" name="dosage1" class="form-control daily">
  </div>
  <div class="form-group col-md-6 data_1" id="data_1">
   <label class="control-label" for="name">Date</label>
   <div class="input-group date">
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       <input type="text" class="form-control" name="med_date1" value="{{$today = date('Y-m-d')}}">
   </div>
 </div>

 <div class="form-group col-md-12">
 <label class="control-label" for="name">Drug Name</label>
 <div>
   <input type="text" name="drug_id2" class="form-control daily">
 </div>
 </div>
 <div class="form-group col-md-6">
  <label class="control-label" for="name">Dosage</label>
  <input type="text" name="dosage2" class="form-control daily">
 </div>
 <div class="form-group col-md-6 data_1" id="data_1">
  <label class="control-label" for="name">Date</label>
  <div class="input-group date">
      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
      <input type="text" class="form-control" name="med_date2" value="{{$today = date('Y-m-d')}}">
  </div>
</div>


 </div>
 <div class="col-lg-6">

   <div class="form-group col-md-12">
   <label class="control-label" for="name">Drug Name</label>
   <div>
     <input type="text" name="drug_id3" class="form-control daily">
   </div>
   </div>
   <div class="form-group col-md-6">
    <label class="control-label" for="name">Dosage</label>
    <input type="text" name="dosage3" class="form-control daily">
   </div>
   <div class="form-group col-md-6 data_1" id="data_1">
    <label class="control-label" for="name">Date</label>
    <div class="input-group date">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input type="text" class="form-control" name="med_date3" value="{{$today = date('Y-m-d')}}">
    </div>
  </div>
  <div class="form-group col-md-12">
  <label class="control-label" for="name">Drug Name</label>
  <div>
    <input type="text" name="drug_id4" class="form-control daily">
  </div>
  </div>
  <div class="form-group col-md-6">
   <label class="control-label" for="name">Dosage</label>
   <input type="text" name="dosage4" class="form-control daily">
  </div>
  <div class="form-group col-md-6 data_1" id="data_1">
   <label class="control-label" for="name">Date</label>
   <div class="input-group date">
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       <input type="text" class="form-control" name="med_date4" value="{{$today = date('Y-m-d')}}">
   </div>
 </div>
 <div class="form-group col-md-12">
 <label class="control-label" for="name">Drug Name</label>
 <div>
   <input type="text" name="drug_id5" class="form-control daily">
 </div>
 </div>
 <div class="form-group col-md-6">
  <label class="control-label" for="name">Dosage</label>
  <input type="text" name="dosage5" class="form-control daily">
 </div>
 <div class="form-group col-md-6 data_1" id="data_1">
  <label class="control-label" for="name">Date</label>
  <div class="input-group date">
      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
      <input type="text" class="form-control" name="med_date5" value="{{$today = date('Y-m-d')}}">
  </div>
</div>




  </div>
 <div class="pull-right">
 <button class="btn btn-primary"  type="submit"><strong>Submit</strong></button>
 {!! Form::close() !!}
   </div>
  </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section5">
                        <h3>Section 3</h3>
                        <div class="col-sm-4">
                          {!! Form::open(array('url' => 'doctor.vaccine','method'=>'POST','class'=>'form-horizontal')) !!}
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="hidden" value="{{$patient->id}}" name="afya_user_id">
                              <input type="hidden" value="{{$patient->appid}}" name="appointment_id">

    <div class="form-group">
     <label class="control-label" for="name">Disease Name</label>
     <select class="form-control m-b allergies" name="disease_name" style="width:100%">
       <option value="">Please select one</option>
       @foreach ($vaccines as $start)
       <option value="{{$start->id}}">{{$start->disease}} ({{$start->antigen}})</option>
       @endforeach
     </select>
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
     <label class="control-label" for="name">Vaccine Name</label>
     <input type="text" name="vac_name" class="form-control daily"  placeholder="">
    </div>
    </div>

    <div class="col-sm-4">
      <div class="form-group data_1">
      <label class="control-label" for="name">Date Give</label>
      <div class="input-group date">
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
          <input type="text" class="form-control" name="vac_date" value="{{$today = date('Y-m-d')}}">
      </div>
  </div>
</div>
<div class="pull-right">
<button class="btn btn-primary"  type="submit"><strong>Submit</strong></button>
{!! Form::close() !!}
  </div>

</div>
<div role="tabpanel" class="tab-pane fade" id="Section6">
    <h3>Abnormalities</h3>
    <div class="col-sm-6 b-r">
      {!! Form::open(array('url' => 'doctor.abnormal','method'=>'POST','class'=>'form-horizontal')) !!}
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" value="{{$patient->id}}" name="afya_user_id">
          <input type="hidden" value="{{$patient->appid}}" name="appointment_id">

            <div class="form-group col-sm-6">
            <label class="control-label" for="name">Abnormality 1</label>
            <input type="text" name="abnm1" class="form-control daily"  placeholder="i.e Sleep">
            </div>
            <div class="form-group col-sm-6">
            <label class="control-label" for="name">Abnormality 1 Status</label>
            <input type="text" name="abnm11" class="form-control daily"  placeholder="">
            </div>
            <div class="form-group col-sm-6">
            <label class="control-label" for="name">Abnormality 2</label>
            <input type="text" name="abnm2" class="form-control daily"  placeholder="i. e Urinary">
            </div>
            <div class="form-group col-sm-6">
            <label class="control-label" for="name">Abnormality 2 Status</label>
            <input type="text" name="abnm22" class="form-control daily"  placeholder="">
            </div>

            </div>
            <div class="col-sm-6">

              <div class="form-group col-sm-6">
              <label class="control-label" for="name">Abnormality 3</label>
              <input type="text" name="abnm3" class="form-control daily"  placeholder="i.e Bowel">
              </div>
              <div class="form-group col-sm-6">
              <label class="control-label" for="name">Abnormality Status</label>
              <input type="text" name="abnm33" class="form-control daily"  placeholder="">
              </div>
              <div class="form-group col-sm-6">
              <label class="control-label" for="name">Abnormality 4</label>
              <input type="text" name="abnm4" class="form-control daily"  placeholder="Apetite">
              </div>
              <div class="form-group col-sm-6">
              <label class="control-label" for="name">Abnormality 4 Status</label>
              <input type="text" name="abnm44" class="form-control daily"  placeholder="">
              </div>

            </div>
            <div class="pull-right">
            <button class="btn btn-primary"  type="submit"><strong>Submit</strong></button>
            {!! Form::close() !!}
              </div>
                    </div>
                    <!-- <div role="tabpanel" class="tab-pane fade" id="Section7">
                        <h3>Section 3</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce semper, magna a ultricies volutpat, mi eros viverra massa, vitae consequat nisi justo in tortor. Proin accumsan felis ac felis dapibus, non iaculis mi varius.</p>
                    </div> -->

                </div>
            </div>
        </div>
    </div>
  </div>
</div>




@endsection
@section('script-test')
<script>
$(document).ready(function() {
// Smart Wizard
$("#wizard").steps();
$('.allergies').select2({
   placeholder: "Please Select the applicable...",

});

$('#data_21 .input-group.date').datepicker({
            startView: 1,
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            format: "yyyy-mm-dd"
        });
        if($('input[name=smoker]:checked').val()=='YES'){
              $(".cigarretes").show();
              $(".period").show();
              $(".eversmoked").hide()
            }else{
              $(".eversmoked").show();
              $(".cigarretes").hide();
              $(".stopdate").hide();
              $(".period").hide();
        }
        if($('input[name=ever_smoked]:checked').val()=='YES'){

              $(".stopdate").show();
              $(".period").show();
            }else{
              $(".stopdate").hide();

              $(".period").hide();
        }
        $(".smoker").click(function(){
            if($('input[name=smoker]:checked').val()=='YES'){
              $(".cigarretes").show();
              $(".eversmoked").hide()
              $(".period").show();
            }else{
              $(".eversmoked").show();
              $(".cigarretes").hide();
              $(".stopdate").hide();
              $(".period").hide();
            }
        });
        $(".eversmoked").click(function(){
            if($('input[name=ever_smoked]:checked').val()=='YES'){
              $(".stopdate").show();
              $(".period").show();
            }else{
              $(".stopdate").hide();
              $(".period").hide();
            }
        });

        if($('input[name=drink]:checked').val()=='YES'){
              $(".frequency").show();
            }else{
              $(".frequency").hide();
        }
        if($('input[name=used_recreational_drugs]:checked').val()=='YES'){
              $(".drug_type").show();
            }else{
              $(".drug_type").hide();
        }
        $(".drink").click(function(){
            if($('input[name=drink]:checked').val()=='YES'){
                  $(".frequency").show();
                }else{
                  $(".frequency").hide();
            }
        });
        $(".drugs").click(function(){
            if($('input[name=used_recreational_drugs]:checked').val()=='YES'){
              $(".drug_type").show();
            }else{
              $(".drug_type").hide();
           }
        });
$('.chosen-select').chosen({width: "100%"});

$(".chronic").select2({
   placeholder: "Select chronic diseases...",
   minimumInputLength: 2,
   ajax: {
       url: '/tag/chronic',
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
$('.data_1 .input-group.date').datepicker({
              todayBtn: "linked",
              keyboardNavigation: false,
              forceParse: false,
              calendarWeeks: true,
              autoclose: true
          });

  $('.clockpicker').clockpicker();



});

</script>

@endsection
