@extends('layouts.nurse_layout')
@section('title', 'Patient Details')
@section('content')

<?php    $pat=$patient->id;  ?>

@section('leftmenu')
@include('includes.nurse_inc.leftmenu2')
@endsection
@include('includes.nurse_inc.topnavbar')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
{!! Form::open(array('url' => 'pathistory','method'=>'POST','class'=>'form-horizontal')) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" value="{{$patient->id}}" name="afya_user_id">
                  <input type="hidden" value="{{$patient->appid}}" name="appid">
<div class="ibox-content">
  <div id="wizard">

                            <h1>Smoking & Alcohol/Drug Details </h1>
                            <div class="step-content">
                                <div class="col-sm-6 b-r"><h3>Smoking History</h3>

                                @if($smoking)  <input type="hidden" value="{{$smoking->id}}" name="smoking_id">@endif

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
                                <div class="col-sm-6"><h3>Alcohol/Drug History</h3>
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





                                </div>



                            </div>

                            <h1>Self Reported Medical History</h1>
                            <div class="step-content">
                     <div class="col-sm-4 b-r">
                       <div class="form-group">
                         @if($medical)  <input type="hidden" value="{{$medical->id}}" name="medical_id">@endif

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
</div>
<div class="col-sm-4 b-r">
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
           </div>
           <div class="col-sm-4 b-r">


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
                         </div>

                            <h1>Self Reported Surgical Procedures & Chronic Diseases</h1>
                            <div class="step-content">
                              <div class="col-sm-6 b-r">

         <div class="form-group col-sm-8">  <h3>Surgical Procedures</h3>
           <label class="control-label" for="name">Procedure Name</label>
           <input type="text" name="name_of_surgery" class="form-control" placeholder="Name of Procedure">
         </div>

         <div class="form-group col-sm-8">
           <label class="control-label" for="name">Procedure Date</label>
           <input type="text" name="surgery_date" class="form-control daily"  placeholder="200/01/12">
         </div>
</div>
 <div class="col-sm-6">  <h3>Chronic Diseases</h3>

<div class="form-group ">
<label >Chronic Diseases:</label>
<select multiple="multiple" id="chronic" name="chronic[]" class="form-control chronic" style="width:100%" ></select>

</div>


</div>
      </div>

                            <h1>Self Reported Medications & Allergies</h1>
                            <div class="step-content">
                              <div class="col-lg-4 b-r">
                                <div class="form-group col-md-11">
                                <label class="control-label" for="name">Medication Name</label>
                                <div>
                                <select name="drug_id[]" multiple data-placeholder="Choose a Drug..." class="chosen-select" >
                                <option value="">Select</option>
                                @foreach($drugs as $drug)
                                  <option value="{{$drug->id}}">{{$drug->drugname}}</option>
                                @endforeach
                                </select>
                                </div>
                                </div>

                                <div class="form-group col-md-11">
                                 <label class="control-label" for="name">Medication Date</label>
                                 <input type="text" name="med_date" class="form-control daily">
                                </div>



                                   </div>
                                     <div class="col-lg-4 b-r">

                                     <div class="form-group col-md-11">
                                   <label>Drug Allergy</label><br>
                                   <select multiple="multiple" class="form-control allergies" name="drugs[]" style="width:100%">
                             <?php $druglists = DB::table('allergies_type')->where('allergies_id',1)->get();?>
                                     @foreach($druglists as $druglist)
                                      <option value="{{$druglist->id}}">{{$druglist->name}}</option>
                                    @endforeach
                                   </select>
                                 </div>

                               <div class="form-group col-md-11"> <label>Food Allergy</label><br>
                                 <select multiple="multiple" class="form-control allergies" name="foods[]" style="width:100%" >
                                    <?php $foods = DB::table('allergies_type')->where('allergies_id',2)->get();?>
                                          @foreach($foods as $food)
                                           <option value="{{$food->id}}">{{$food->name}}</option>
                                         @endforeach
                                     </select>
                                  </div>
                             <div class="form-group col-md-11"><label>Latex Allergy</label><br>
                               <select multiple="multiple" class="form-control allergies" name="latexs[]"  style="width:100%">
                             <?php $foods = DB::table('allergies_type')->where('allergies_id',3)->get();?>
                                @foreach($foods as $food)
                                 <option value="{{$food->id}}">{{$food->name}}</option>
                               @endforeach
                              </select>
                             </div>

                             <div class="form-group col-md-11"><label> Mold Allergy </label><br>
                                <select multiple="multiple" class="form-control allergies" name="molds[]" style="width:100%" >
                                 <?php $foods = DB::table('allergies_type')->where('allergies_id',4)->get();?>
                                       @foreach($foods as $food)
                                        <option value="{{$food->id}}">{{$food->name}}</option>
                                      @endforeach
                                     </select>
                               </div>
                             </div>
                               <div class="col-lg-4 b-r">
                             <div class="form-group col-md-11"><label>Pet Allergy</label><br>
                              <select multiple="multiple" class="form-control allergies" name="pets[]"  style="width:100%">
                                 <?php $foods =  DB::table('allergies_type')->where('allergies_id',5)->get();?>
                                       @foreach($foods as $food)
                                        <option value="{{$food->id}}">{{$food->name}}</option>
                                      @endforeach
                                     </select>
                               </div>

                             <div class="form-group col-md-11"><label>Pollen Allergy</label><br>
                              <select multiple="multiple" class="form-control allergies" name="pollens[]" style="width:100%" >
                                 <?php $foods = DB::table('allergies_type')->where('allergies_id',6)->get();?>
                                               @foreach($foods as $food)
                                                <option value="{{$food->id}}">{{$food->name}}</option>
                                              @endforeach
                                             </select>
                               </div>
                             <div class="form-group col-md-11"><label>Insect Allergy</label>
                               <select multiple="multiple" class="form-control allergies" name="insects[]"  style="width:100%">
                                  <?php $foods = DB::table('allergies_type')->where('allergies_id',7)->get();?>
                                    @foreach($foods as $food)
                                     <option value="{{$food->id}}">{{$food->name}}</option>
                                   @endforeach
                                  </select>
                             </div>



                                   </div>

                            </div>
                            <h1>Vaccinations</h1>
                            <div class="step-content">
                              <div class="col-sm-6 b-r">

          <div class="form-group col-sm-8">
           <label class="control-label" for="name">Disease Name</label>
           <select class="form-control m-b allergies" name="disease_name" style="width:100%">
             <option value="">Please select one</option>
             @foreach ($vaccines as $start)
             <option value="{{$start->id}}">{{$start->disease}} ({{$start->antigen}})</option>
             @endforeach
           </select>
          </div>

          <div class="form-group col-sm-8">
           <label class="control-label" for="name">Vaccine Name</label>
           <input type="text" name="vac_name" class="form-control daily"  placeholder="200/01/12">
          </div>
          </div>
          <div class="col-sm-6">

          <div class="form-group ">
          <label >Date Given</label>
          <input type="text" name="vac_date" class="form-control daily"  placeholder="200/01/12">

          </div>


          </div>
          </div>
                        </div>
                    <div class="wizfit  white-bg">
<a href="{{ url('registrar.show',$patient->id) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </a>

                        <div class="pull-right">
                        <button class="btn btn-primary"  type="submit"><strong>Submit</strong></button>
                        {!! Form::close() !!}
</div>
</div>
</div>



          </br>

                </div>
            </div>
            </div>
          </div>



@endsection
@section('script')
<script>
$(document).ready(function() {
// Smart Wizard
$("#wizard").steps();
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

  $('.allergies').select2();

});

</script>
<script>




</script>
        @endsection
