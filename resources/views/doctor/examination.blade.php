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
$dependantAge = $pdetails->depdob;
$AfyaUserAge = $pdetails->dob;
$condition = $pdetails->condition;

?>



@section('leftmenu')
@include('includes.doc_inc.leftmenu2')
@endsection

@include('includes.doc_inc.topnavbar_v2')


<div class="row wrapper border-bottom page-heading">
  <div class="ibox float-e-margins">
    <div class="col-lg-12">
      <div class="tabs-container">
        <?php if ($pdetails->persontreated=='Self') {
          ?>
          <?php


          $gexam = DB::table('general_examination')->where('appointment_id',$app_id)->first();
          // dd($app_id);

          ?>

            <!-- General Examinations -->
            <div class="wrapper wrapper-content">
              <div class="col-lg-12">
                <div class="ibox float-e-margins">
                  <div class="ibox-title">
                    <h5>Examinations</h5>

                  </div>
                  <div class="ibox-content">
                    <div class="row">
                      <div class="col-sm-4 "><h3 class="m-t-none m-b"></h3>
                        <form class="form-horizontal" role="form" method="POST" action="/generalExamination" novalidate>
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
                          <div class="form-group"><label>General Examination</label> <input type="text" value="@if($gexam){{$gexam->g_examination}}@endif" name="g_examination" class="form-control"></div>
                          <div class="form-group"><label>CVS</label> <input type="text" value="@if($gexam){{$gexam->cvs}}@endif" name="cvs" class="form-control"></div>
                        </div>
                        <div class="col-sm-4"><h4></h4>
                          <div class="form-group"><label>RS</label> <input type="text" value="@if($gexam){{$gexam->rs}}@endif" name="rs" class="form-control"></div>
                          <div class="form-group"><label>PA</label> <input type="text" value="@if($gexam){{$gexam->pa}}@endif" name="pa" class="form-control"></div>
                        </div>
                        <div class="col-sm-4"><h4></h4>
                          <div class="form-group"><label>CNS</label> <input type="text" value="@if($gexam){{$gexam->cns}}@endif" name="cns" class="form-control"></div>
                          <div class="form-group"><label>MSS</label> <input type="text" value="@if($gexam){{$gexam->mss}}@endif" name="mss" class="form-control"></div>
                          <div class="form-group"><label>PERIPHERIES</label> <input type="text" value="@if($gexam){{$gexam->peripheries}}@endif" name="peripheries" class="form-control"></div>
                        </div>

  <div class="col-lg-4 col-md-offset-8">
                          <button class="btn btn-sm btn-primary pull-right" type="submit"><strong>@if($gexam)UPDATE @else SUBMIT @endif</strong></button>
                        </div>
                        {{ Form::close() }}


                      </div>
                    </div>
                  </div>
                </div>
              </div>




        <?php }else { ?>

          @include('doctor.triage59')

        <?php } ?>

      </div>
    </div>





  </div><!--tfloat-e-margins-->
</div><!--row wrapper-->
@endsection
@section('script-test')

<script type="text/javascript">
$(document).ready(function(){



  $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });


  $(".chief").select2({
    placeholder: "Select chief compliant...",
    minimumInputLength: 2,
    ajax: {
      url: '/tagprv/chief',
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
