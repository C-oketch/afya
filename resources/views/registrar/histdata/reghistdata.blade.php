@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')
@include('includes.registrar.topnavbar_v3')
                <div class="col-lg-4">
                    <h2>Self Reported Details</h2>
                </div>
                <div class="col-lg-6">
                    <div class="title-action">
                      <a href="{{ url('registrar.shows',$patient->id) }}" class="btn btn-primary"><i class="fa fa-file"></i>View Details</a>
                      <a href="{{ url('register_new_patient') }}" class="btn btn-primary"><i class="fa fa-refresh"></i>On Boarding </a>
                      <a href="{{ url('registrar.select',$patient->id) }}" class="btn btn-primary"><i class="fa fa-arrow-right"></i>Create Visit</a>
                    </div>
                </div>
            <div class="row m-t-lg">
              <div class="col-lg-12">
                <div class="tabs-container">

                  <div class="tabs-left">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="{{ url('registrar.histdetails',$patient->app_id) }}">Smoking & Alcohol</a></li>
                      <li><a href="{{ url('registrar.mhistdata',$patient->app_id) }}" >Medical History</a></li>
                      <li><a href="{{ url('registrar.surghistdata',$patient->app_id) }}" >Surgical Procedures</a></li>
                      <li><a href="{{ url('registrar.chronichistdata',$patient->app_id) }}" >Chronic Disease</a></li>
                      <li><a href="{{ url('registrar.medhistdata',$patient->app_id) }}">Medications</a></li>
                      <li><a href="{{ url('registrar.allergyhistdata',$patient->app_id) }}">Allergies</a></li>
                    <li><a href="{{ url('registrar.vacchistdata',$patient->app_id) }}" >Vaccinations</a></li>
                      <li><a href="{{ url('registrar.abnorhistdata',$patient->app_id) }}">Functions</a></li>

                    </ul>
                    <div class="tab-content ">
                      <div id="tab-6" class="tab-pane active">
                        <div class="panel-body">
                          {!! Form::open(array('url' => 'registrar.smoking_store','method'=>'POST','class'=>'form-horizontal')) !!}
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" value="{{$patient->id}}" name="afya_user_id">
                          <input type="hidden" value="{{$patient->app_id}}" name="appointment_id">

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
                      </div>

                    </div>

                  </div>

                </div>
              </div>
            </div>
@endsection
@section('script-reg')
<script>
$(document).ready(function() {

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

});
</script>

@endsection
