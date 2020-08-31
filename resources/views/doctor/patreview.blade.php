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
  <!-- General Examinations -->
            <div class="wrapper wrapper-content">
              <div class="col-lg-12">
                <div class="ibox float-e-margins">
                  <div class="ibox-title">
                    <h5>Review</h5>
                  </div>
                  <div class="ibox-content">
                    <div class="row">
        <div id="reviewDIV" class="col-md-6">
        <div id="reviewcontent" >
          <h5>Previous Reviews Notes</h5>
        <ul class="list-group elements-list">

  @foreach($revs as $tstdn)
        <li class="list-group-item">
        <strong class="mr-1">{{$tstdn->created_at}}</strong>
        <div class="small m-t-xs">
        <p>{{$tstdn->notes}}</p>
        </div>
        </li>
    @endforeach
        </ul>
        </div>
        </div>

                  <div class="col-md-6">
                    <h5>Diagnosis</h5>
                    @foreach($diagnosis as $diag)
                    <div class="col-md-6">
                    <li class="list-group-item">
                    <div class="small m-t-xs">  <p>{{$diag->condition}}</p>
                    </div>
                    </li>
                      </div>
                    @endforeach


                    <form class="form-horizontal" role="form" method="POST" action="/patientreview">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}

                    <div class="form-group col-md-12">
                     <label for="role" class="control-label">Review note</label>
   <textarea class="form-control" name="rev_note" rows="7">@if($revstoday){{ $revstoday->notes }}@endif</textarea>
                  </div>
                <div class="col-lg-4 col-md-offset-8">
                      <button class="btn btn-sm btn-primary pull-right" type="submit"><strong>SUBMIT</strong></button>
                    </div>
                    {{ Form::close() }}
                 </div>

                </div>

              </div>
                  </div>
                </div>
              </div>

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
