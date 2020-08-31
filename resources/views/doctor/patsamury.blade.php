@extends('layouts.doctor_layout')
@section('title', 'Triage')
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
?>

<?php


   $stat= $pdetails->status;
   $afyauserId= $pdetails->afya_user_id;
    $dependantId= $pdetails->persontreated;
    $app_id =  $pdetails->id;
    $doc_id= $pdetails->doc_id;
    $fac_id= $pdetails->facility_id;
    $fac_setup= $pdetails->set_up;
  $condition = $pdetails->condition;

?>



@section('leftmenu')
@include('includes.doc_inc.leftmenu2')
@endsection
<!--tabs Menus-->
@include('includes.doc_inc.topnavbar_v2')


<!--tabs Menus-->
<div class="row m-t-lg">
          <div class="col-lg-12">
              <div class="tabs-container">

                  <div class="tabs-left">
                      <ul class="nav nav-tabs">
                          <li class="active"><a data-toggle="tab" href="#tab-1">Presenting Complaints</a></li>
                          <li class=""><a data-toggle="tab" href="#tab-2">Current Medication</a></li>
                          <li class=""><a data-toggle="tab" href="#tab-3">Chronic Disease</a></li>
                          <li class=""><a data-toggle="tab" href="#tab-4">Allergies</a></li>
                          <li class=""><a data-toggle="tab" href="#tab-7">Social History</a></li>
                          <li class=""><a data-toggle="tab" href="#tab-5">Systemic Inquiry</a></li>
                          <li class=""><a data-toggle="tab" href="#tab-6">Family History</a></li>




                      </ul>
                      <div class="tab-content ">

    <div id="tab-1" class="tab-pane active">
        <div class="panel-body">
          <form class="form-horizontal" role="form" method="POST" action="/summPatients" >
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
          {{ Form::hidden('afya_user_id',$afyauserId, array('class' => 'form-control')) }}

          <div class="form-group">
            <label class="control-label">Presenting Complaints </label><br>
              <div class="col-lg-10">
              <textarea class="form-control"   name="complaints">@if($psummary){{$psummary->notes}}  @endif</textarea>
            </div>
          </div>

        </div>
    </div>
<div id="tab-2" class="tab-pane">
<div class="panel-body">
<?php $i=1;?>

  <h3> Current Medication</h3>
  @if($drugs)
 <h4>Drugs</h4>
  <div class="col-md-6">
    @foreach($drugs as $mds)
    <div class="col-md-6">
    {{$i}} {{'.'}} {{$mds->drugs}}
    </div>
      <?php  $i++; ?>
    @endforeach
    </div>
  @endif

      <div class="col-md-6">
  <div class="table-responsive">
    <table class="table borderless" id="procedure_table" align=center>
  <tr id="row1">
        <td><input type="text" name="drugs1" placeholder="drug description" class="form-control"></td>
  </tr>
  <tr>
  <td>  <input type="button" id="cm1" value="ADD MORE" class='btn btn-primary'></td>
  </tr>
      <tr id="cmd2" class="ficha">
        <td><input type="text" name="drugs2" placeholder="drug description" class="form-control"></td>
      </tr>
      <tr>
      <td>  <input type="button" id="cm2" value="ADD MORE" class='btn btn-primary ficha'></td>
      </tr>
            <tr id="cmd3" class="ficha">
        <td><input type="text" name="drugs3" placeholder="drug description" class="form-control"></td>
      </tr>
      <tr>
      <td>  <input type="button" id="cm3" value="ADD MORE" class='btn btn-primary ficha'></td>
      </tr>
            <tr id="cmd4" class="ficha">
        <td><input type="text" name="drugs4" placeholder="drug description" class="form-control"></td>
      </tr>
      <tr>
      <td>  <input type="button" id="cm4" value="ADD MORE" class='btn btn-primary ficha'></td>
      </tr>
            <tr id="cmd5" class="ficha">
        <td><input type="text" name="drugs5" placeholder="drug description" class="form-control"></td>
      </tr>
    </table>

  </div>
</div>

</div>
</div>
<div id="tab-3" class="tab-pane">
  <div class="panel-body">
      <div class="col-md-4">
    @if($medh)
   <table class="table borderless" align="center">
      <thead>
          <tr>
              <th>Condition</th>
          </tr>
      </thead>
        <tbody>
      @foreach($medh as $mds)
       <tr>
        <td>{{$mds->disease_id}} </td>
      </tr>
      @endforeach
      <tbody>
    </table>
    @endif
  </div>
    <div class="col-md-8">
      <div class="table-responsive">
        <table class="table borderless" id="employee_table" align=center>


          <tr id="con1">
            <td><input type="text" name="name1" placeholder="Condition Name" class="form-control"></td>
          </tr>

          <tr>
          <td>  <input type="button" id="cond2" value="ADD MORE" class='btn btn-primary'></td>
          </tr>
          <tr id="con2" class="ficha">
            <td><input type="text" name="name2" placeholder="Condition Name" class="form-control"></td>
          </tr>

          <tr>
          <td>  <input type="button" id="cond3" value="ADD MORE" class='btn btn-primary ficha'></td>
          </tr>
          <tr id="con3" class="ficha">
            <td><input type="text" name="name3" placeholder="Condition Name" class="form-control"></td>
          </tr>

          <tr>
          <td>  <input type="button" id="cond4" value="ADD MORE" class='btn btn-primary ficha'></td>
          </tr>
          <tr id="con4" class="ficha">
            <td><input type="text" name="name4" placeholder="Condition Name" class="form-control"></td>
          </tr>

          <tr>
          <td>  <input type="button" id="cond5" value="ADD MORE" class='btn btn-primary ficha'></td>
          </tr>
          <tr id="con5" class="ficha">
            <td><input type="text" name="name5" placeholder="Condition Name" class="form-control"></td>
          </tr>



        </table>
    </div>
    </div>
</div>
</div>
<div id="tab-4" class="tab-pane">
<div class="panel-body">

@if($allergies)
<table class="table borderless" align="center">
  <thead>
      <tr>
          <th>Condition</th>
          <th>Description</th>
      </tr>
  </thead>
    <tbody>
  @foreach($allergies as $allerg)
   <tr>
    <td>{{$allerg->allergies}} </td> <td>{{$allerg->status}}</td>
  </tr>
  @endforeach
  <tbody>
</table>
@endif

  <div class="table-responsive">
    <table class="table borderless" id="procedure_table" align=center>
<tr id="row1">
        <td><input type="text" name="allergies1" placeholder="Allergy" class="form-control"></td>
        <td><input type="text" name="status1"  placeholder="Description" class="form-control"></td>
</tr>
<tr>
<td>  <input type="button" id="aller1" value="ADD MORE" class='btn btn-primary'></td>
</tr>
      <tr id="allerge2" class="ficha">
        <td><input type="text" name="allergies2" placeholder="Allergy" class="form-control"></td>
        <td><input type="text" name="status2"  placeholder="Description" class="form-control"></td>

      </tr>
      <tr>
      <td>  <input type="button" id="aller2" value="ADD MORE" class='btn btn-primary ficha'></td>
      </tr>
            <tr id="allerge3" class="ficha">
        <td><input type="text" name="allergies3" placeholder="Allergy" class="form-control"></td>
        <td><input type="text" name="status3"  placeholder="Description" class="form-control"></td>
      </tr>
      <tr>
      <td>  <input type="button" id="aller3" value="ADD MORE" class='btn btn-primary ficha'></td>
      </tr>
            <tr id="allerge4" class="ficha">
        <td><input type="text" name="allergies4" placeholder="Allergy" class="form-control"></td>
        <td><input type="text" name="status4"  placeholder="Description" class="form-control"></td>
      </tr>
      <tr>
      <td>  <input type="button" id="aller4" value="ADD MORE" class='btn btn-primary ficha'></td>
      </tr>
            <tr id="allerge5" class="ficha">
        <td><input type="text" name="allergies5" placeholder="Allergy" class="form-control"></td>
        <td><input type="text" name="status5"  placeholder="Description" class="form-control"></td>
      </tr>
    </table>

</div>

</div>
</div>
<?php
$bowel = DB::table('patient_systemic')->where([['appointment_id',$app_id],['systemic_id',1]])->first();
$bowel2 = DB::table('patient_systemic')->where([['appointment_id',$app_id],['systemic_id',2]])->first();

$urinary3 = DB::table('patient_systemic')->where([['appointment_id',$app_id],['systemic_id',3]])->first();
$urinary4 = DB::table('patient_systemic')->where([['appointment_id',$app_id],['systemic_id',4]])->first();

$sleep5 = DB::table('patient_systemic')->where([['appointment_id',$app_id],['systemic_id',5]])->first();
$sleep6 = DB::table('patient_systemic')->where([['appointment_id',$app_id],['systemic_id',6]])->first();

$appetite7 = DB::table('patient_systemic')->where([['appointment_id',$app_id],['systemic_id',7]])->first();
$appetite8 = DB::table('patient_systemic')->where([['appointment_id',$app_id],['systemic_id',8]])->first();


if($bowel)   { $bowel_id=$bowel->id; }      elseif ($bowel2){$bowel_id=$bowel2->id; }else { $bowel_id=''; }
if($urinary3){ $urinary_id=$urinary3->id; } elseif ($urinary4){$urinary_id=$urinary4->id; }else { $urinary_id=''; }
if($sleep5)  { $sleep_id=$sleep5->id; }     elseif ($sleep6){$sleep_id=$sleep6->id; }else { $sleep_id=''; }
if($appetite7)   { $appetite_id=$appetite7->id; } elseif ($appetite8){$appetite_id=$appetite8->id; }else { $appetite_id=''; }
?>
{{ Form::hidden('bowel_id',$bowel_id, array('class' => 'form-control')) }}
{{ Form::hidden('urinary_id',$urinary_id, array('class' => 'form-control')) }}
{{ Form::hidden('sleep_id',$sleep_id, array('class' => 'form-control')) }}
{{ Form::hidden('appetite_id',$appetite_id, array('class' => 'form-control')) }}

<div id="tab-5" class="tab-pane">
<div class="panel-body">
<div class="col-md-6 b-r">
<div class="form-group">
  <label class="control-label">Bowel Habits ?</label>
  <div class="">
    <label class="checkbox-inline"> <input type="radio" class="bowels"  name="bowel" value="1"  @if($bowel) checked="checked" @endif /> Normal</label>
    <label class="checkbox-inline"> <input type="radio" class="bowels"  name="bowel" value="2"  @if($bowel2) checked="checked" @endif />Abnormal</label>
  </div>
</div>
<div class="form-group bowelexp @if($bowel2) @else ficha @endif">
  <label class="control-label">Details</label>
  <textarea class="form-control" rows="3"  name="bowel_details"  name="bowel_dls">@if($bowel2){{$bowel2->description}} @endif</textarea>
</div>

<div class="form-group">
  <label class="control-label">Urinary Habits ?</label>
  <div class="">
    <label class="checkbox-inline"> <input type="radio" class="urinarys"  name="urinary" value="3" @if($urinary3) checked="checked" @endif /> Normal</label>
    <label class="checkbox-inline"> <input type="radio" class="urinarys"  name="urinary" value="4" @if($urinary4) checked="checked" @endif/> Abnormal</label>
  </div>
</div>
<div class="form-group urinaryexp @if($urinary4) @else ficha @endif">
  <label class="control-label">Details</label>
  <textarea class="form-control" rows="3"  name="urinary_details">@if($urinary4){{$urinary4->description}} @endif</textarea>
</div>

</div>
<div class="col-md-6">

<div class="form-group">
  <label class="control-label">Sleep Habits ?</label>
  <div class="">
    <label class="checkbox-inline"> <input type="radio" class="sleeps"  name="sleep" value="5" @if($sleep5) checked="checked" @endif /> Normal</label>
    <label class="checkbox-inline"> <input type="radio" class="sleeps"  name="sleep" value="6" @if($sleep6) checked="checked" @endif /> Abnormal</label>
  </div>
</div>
<div class="form-group sleepexp @if($sleep6) @else ficha @endif">
  <label class="control-label">Details</label>
  <textarea class="form-control" rows="3"  name="sleep_details">@if($sleep6){{$sleep6->description}} @endif</textarea>
</div>

<div class="form-group">
  <label class="control-label">Appetite Habits ?</label>
  <div class="">
    <label class="checkbox-inline"> <input type="radio" class="appetites"  name="appetite" value="7" @if($appetite7) checked="checked" @endif /> Normal</label>
    <label class="checkbox-inline"> <input type="radio" class="appetites"  name="appetite" value="8" @if($appetite8) checked="checked" @endif /> Abnormal</label>
  </div>
</div>
<div class="form-group appetiteexp @if($appetite8) @else ficha @endif">
  <label class="control-label">Details</label>
  <textarea class="form-control" rows="3"  name="appetite_details">@if($appetite8){{$appetite8->description}} @endif</textarea>
</div>
</div>

</div>
</div>
<div id="tab-6" class="tab-pane">
<div class="panel-body">

  <div class="form-group col-lg-10">
    <label class="control-label">Father </label><br>
      <textarea class="form-control"   name="father">@if($fsummary){{$fsummary->notes}}  @endif</textarea>
  </div>
  <div class="form-group col-lg-10">
    <label class="control-label">Mother </label><br>
      <textarea class="form-control"   name="mother">@if($msummary){{$msummary->notes}}  @endif</textarea>
  </div>
  <div class="form-group col-lg-10">
    <label class="control-label">Brothers </label><br>
      <textarea class="form-control" name="brother">@if($bsummary){{$bsummary->notes}}  @endif</textarea>
  </div>
  <div class="form-group col-lg-10">
    <label class="control-label">Sisters </label><br>
      <textarea class="form-control" name="sister">@if($ssummary){{$ssummary->notes}}  @endif</textarea>
  </div>
</div>
</div>


<div id="tab-7" class="tab-pane">
<div class="panel-body">
  <div class="col-lg-6 b-r"><h3>Smoking Details</h3>
    @if($smoking)<input type="hidden" value="{{$smoking->id}}" name="smoking_id">@endif

    <div class="form-group smoker">
      <label>Are you a smoker?</label>
        <label class="checkbox-inline"> <input type="radio" class="smoker"  name="smoker" value="YES" @if($smoking)     @if($smoking->smoker=='YES') checked @endif  @endif> Yes</label>
        <label class="checkbox-inline"> <input type="radio" class="smoker"  name="smoker" value="NO"   @if($smoking)       @if($smoking->smoker=='NO') checked @endif @endif> No</label>
    </div>

    <div class="form-group cigarretes ficha">
      <label>How many cigarretes per day?</label>
        <input type="text" name="cigarretes_per_day" value="@if($smoking){{$smoking->cigarretes_per_day}}@endif" class="form-control" >
    </div>
    <div class="form-group eversmoked">
        <label>Have you ever smoked?  </label>
        <label class="checkbox-inline "> <input type="radio" class="eversmoked" name="ever_smoked" value="YES" @if($smoking) @if($smoking->ever_smoked=='YES') checked @endif @endif> Yes</label>
        <label class="checkbox-inline "> <input type="radio" class="eversmoked" name="ever_smoked" value="NO"  @if($smoking) @if($smoking->ever_smoked=='NO') checked @endif  @endif> No</label>
    </div>
    <div class="form-group stopdate ficha">
      <label><br>When did you stop?</label>
        <input type="text" name="stop_date" value="@if($smoking){{$smoking->stop_date}}@endif" class="form-control monthly" >
    </div>
    <div class="form-group period ficha">
      <label><br>How long did you smoke/have you smoked(years)?</label>
        <select name="period_smoked" class="form-control">
          @if($smoking)  <option value="{{$smoking->period_smoked}}" >{{$smoking->period_smoked}}</option>@endif
          <option value="0">0</option>
          <option value="1">0-1</option>
          @for($i=2;$i< 61;$i++)
          <option value="{{$i}}">{{$i}}</option>
          @endfor
        </select>
    </div>

  </div>
  <div class="col-lg-6"><h3>Alcohol/Drug Details</h3>

    @if($alcohol)  <input type="hidden" value="{{$alcohol->id}}" name="alcohol_id">@endif

    <div class="form-group drink">
      <label>Do you drink Alcohol?</label>
        <label class="checkbox-inline "> <input type="radio" class="drink" name="drink" value="YES" @if($alcohol) @if($alcohol->drink=='YES') checked @endif @endif> Yes</label>
        <label class="checkbox-inline "> <input type="radio" class="drink" name="drink" value="NO"  @if($alcohol) @if($alcohol->drink=='NO') checked @endif  @endif> No</label>
    </div>

    <div class="form-group frequency">
      <label>How how frequent?</label>
        <select name="drinking_frequency" class="form-control">
          @if($alcohol)<option value="{{$alcohol->drinking_frequency}}">{{$alcohol->drinking_frequency}}</option> @endif
          <option value="daily">daily</option>
          <option value="every other day">every other day</option>
          <option value="weekly">weekly</option>
          <option value="Once a month">Once a month</option>
        </select>
      </div>

    <div class="form-group drugs">
      <label>Do you or have you ever used<br> recreational drugs?</label>
        <label class="checkbox-inline "> <input type="radio" class="drugs" name="used_recreational_drugs" value="YES" @if($alcohol) @if($alcohol->used_recreational_drugs=='YES') checked @endif @endif> Yes</label>
        <label class="checkbox-inline "> <input type="radio" class="drugs" name="used_recreational_drugs" value="NO"  @if($alcohol) @if($alcohol->used_recreational_drugs=='NO') checked @endif  @endif> No</label>
    </div>

    <div class="form-group drug_type">
      <label>If yes state type?</label>
        <input type="text" name="drug_type"  value="@if($alcohol){{$alcohol->drug_type}}@endif" class="form-control" >
    </div>

    <div class="form-group">
      <label>Do you drink liquids<br> with caffeine - coffee, tea?</label>
        <label class="checkbox-inline "> <input type="radio" name="caffeine_liquids" value="YES" @if($alcohol) @if($alcohol->caffeine_liquids=='YES') checked @endif @endif > Yes</label>
        <label class="checkbox-inline "> <input type="radio" name="caffeine_liquids" value="NO"  @if($alcohol) @if($alcohol->caffeine_liquids=='NO') checked @endif @endif > No</label>
    </div>
    <br><br>
  </div>


</div>
</div>



<div class="col-md-10 col-md-offset-2">
<button class="btn btn-sm btn-primary btn-rounded btn-block" type="submit"><strong>@if($cmed || $psummary)UPDATE @else SUBMIT @endif </strong></button>
</div>
{{ Form::close() }}
          </div>

      </div>

  </div>
</div>
</div>



@endsection
@section('script-test')
<script type="text/javascript">
$("#cm1").click(function(){
    $("#cmd2").show();
    $("#cm1").hide();
    $("#cm2").show();
});

$("#cm2").click(function(){
    $("#cmd3").show();
    $("#cm2").hide();
    $("#cm3").show();
});

$("#cm3").click(function(){
    $("#cmd4").show();
    $("#cm3").hide();
    $("#cm4").show();
});

$("#cm4").click(function(){
    $("#cmd5").show();
    $("#cm4").hide();
});
</script>

<script>
$(document).ready(function() {

  $(".bowels").click(function(){
  if($('input[name=bowel]:checked').val()=='2'){
    $(".bowelexp").show();
  }else{
    $(".bowelexp").hide();
  }
});


$(".appetites").click(function(){
if($('input[name=appetite]:checked').val()=='8'){
  $(".appetiteexp").show();
}else{
  $(".appetiteexp").hide();
}
});

$(".sleeps").click(function(){
if($('input[name=sleep]:checked').val()=='6'){
  $(".sleepexp").show();
}else{
  $(".sleepexp").hide();
}
});

$(".urinarys").click(function(){
if($('input[name=urinary]:checked').val()=='4'){
  $(".urinaryexp").show();
}else{
  $(".urinaryexp").hide();
}
});


});
</script>
<script type="text/javascript">
$("#aller1").click(function(){
    $("#allerge2").show();
    $("#aller1").hide();
    $("#aller2").show();
});

$("#aller2").click(function(){
    $("#allerge3").show();
    $("#aller2").hide();
    $("#aller3").show();
});

$("#aller3").click(function(){
    $("#allerge4").show();
    $("#aller3").hide();
    $("#aller4").show();
});

$("#aller4").click(function(){
    $("#allerge5").show();
    $("#aller4").hide();
});
</script>

<script type="text/javascript">
$("#cond2").click(function(){
    $("#con2").show();
    $("#cond2").hide();
    $("#cond3").show();

});

$("#cond3").click(function(){
  $("#con3").show();
  $("#cond3").hide();
  $("#cond4").show();
});

$("#cond4").click(function(){
  $("#con4").show();
  $("#cond4").hide();
  $("#cond5").show();
});

$("#cond5").click(function(){
  $("#con5").show();
  $("#cond5").hide();

});
</script>
<script>
$(document).ready(function() {

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
